<?php


namespace App\Http\Controller;

use App\Lib\MyCode;
use App\Lib\MyCommon;
use App\Lib\MyQuit;
use App\Model\Data\AdminData;
use App\Model\Data\PaginationData;
use App\Model\Data\UserData;
use App\Model\Data\WithdrawLogData;
use App\Model\Entity\AppVersion;
use App\Model\Entity\Coin;
use App\Model\Entity\CoinDepositLog;
use App\Model\Entity\CoinWithdrawLog;
use App\Model\Entity\ImgBanner;
use App\Model\Entity\UserBasicalInfo;
use App\Rpc\Lib\CoinInterface;
use App\Rpc\Lib\WalletDwInterface;
use ReflectionException;
use Swoft\Bean\Annotation\Mapping\Inject;
use Swoft\Bean\BeanFactory;
use Swoft\Bean\Exception\ContainerException;
use Swoft\Db\DB;
use Swoft\Db\Exception\DbException;
use Swoft\Http\Message\Request;
use Swoft\Http\Message\Response;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\Middleware;
use Swoft\Http\Server\Annotation\Mapping\Middlewares;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Redis\Redis;
use Swoft\Rpc\Client\Annotation\Mapping\Reference;
use Swoft\Validator\Exception\ValidatorException;
use Throwable;
use App\Http\Middleware\ActionMiddleware;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\PermissionMiddleware;

/**
 * Class systemController
 * @package App\Http\Controller
 * @Controller("/system")
 * @Middlewares({
 *     @Middleware(AuthMiddleware::class),
 *     @Middleware(PermissionMiddleware::class)
 * })
 */
class SystemController
{
    /**
     * 轮播图列表
     * @param Request $request
     * @return mixed
     * @throws DbException
     * @throws Throwable
     * @RequestMapping(method={RequestMethod::GET})
     */
    public function banner(Request $request)
    {
        $params = $request->params;
        $page = $params['page'] ?? 1;
        $size = $params['size'] ?? 10;
        $use_client = $params['use_client'] ?? '';
        $type = $params['type'] ?? '';
        $status = $params['status'] ?? '';
        $where = [];
        if ($use_client) {
            $where[] = ['use_client', '=', $use_client];
        }
        if ($type) {
            $where[] = ['type', '=', $type];
        }
        if ($status) {
            $where[] = ['status', '=', $status];
        }
        $data = PaginationData::table('img_banner')->where($where)->orderBy('sort_num', 'desc')->forPage($page, $size)->get();
        foreach ($data['list'] as $key => $val) {
            $data['list'][$key]['img_src'] = MyCommon::get_filepath($val['img_src']);
            if ($val['link_href'] && $val['type'] === 2) {
                $data['list'][$key]['link_href'] = MyCommon::get_filepath($val['link_href']);
            }
        }

        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'success');
    }

    /**
     * 轮播图添加、编辑
     * @param Request $request
     * @return array
     * @throws DbException
     * @throws ValidatorException
     * @RequestMapping(method={RequestMethod::POST})
     */
    public function do_banner(Request $request)
    {
        $params = $request->params;
        validate($params, 'SystemValidator',
            ['id', 'img_src', 'content', 'sort_num', 'status', 'type', 'scenes_type', 'position', 'use_client', 'action_type']);
        if ($params['action_type'] === 'add') {
            $banner = ImgBanner::new();
        } else {
            $banner = ImgBanner::find($params['id']);
            if (!$banner) {
                return MyQuit::returnMessage(MyCode::PARAM_ERROR, '轮播图信息不存在');
            }
        }
        $img_src = MyCommon::get_filename($params['img_src']);
        if (!$img_src) {
            return MyQuit::returnMessage(MyCode::PARAM_ERROR, '图片路径错误');
        }
        //如果是视频类型
        $link_href = $params['link_href'];
        if ($params['type'] === 2 && !empty($link_href)) {
            $link_href = MyCommon::get_filename($params['link_href']);
            if (!$link_href) {
                return MyQuit::returnMessage(MyCode::PARAM_ERROR, '跳转链接路径错误');
            }
        }
        $banner->setSortNum($params['sort_num']);
        $banner->setUseClient($params['use_client']);
        $banner->setImgSrc($img_src);
        $banner->setType($params['type']);
        $banner->setScenesType($params['scenes_type']);
        $banner->setPosition($params['position']);
        $banner->setStatus($params['status']);
        $banner->setLinkHref($link_href);
        $banner->setContent($params['content']);
        $res = $banner->save();
        if ($res) {
            return MyQuit::returnMessage(MyCode::SUCCESS, 'success');
        }
        return MyQuit::returnMessage(MyCode::SERVER_ERROR, 'server error');
    }

    /**
     * 轮播图单条数据
     * @param $id
     * @return array
     * @throws DbException
     * @RequestMapping(method={RequestMethod::GET}, route="{id}/get_banner")
     */
    public function get_banner(int $id)
    {
        $data = DB::table('img_banner')->where(['id' => $id])->firstArray();
        if ($data) {
            if (!empty($data['img_src'])) {
                $data['img_src'] = MyCommon::get_filepath($data['img_src']);
            }
            $data['link_href_name'] = $data['link_href'];
            if ($data['type'] === 2 && !empty($data['link_href'])) {
                $data['link_href'] = MyCommon::get_filepath($data['link_href']);
            }
        }
        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'success');
    }

    /**
     * app版本列表
     * @param Request $request
     * @return mixed
     * @throws DbException
     * @throws Throwable
     * @RequestMapping(method={RequestMethod::GET}, route="app_version")
     */
    public function app_version(Request $request)
    {
        $params = $request->params;
        $page = $params['page'] ?? 1;
        $size = $params['size'] ?? 10;
        $type = $params['type'] ?? '';
        $isForce = $params['is_force'] ?? '';
        $where = [];
        if ($type) {
            $where[] = ['type', '=', $type];
        }
        if ($isForce || $isForce === '0') {
            $where[] = ['is_force', '=', (int)$isForce];
        }
        $data = PaginationData::table('app_version')->where($where)->forPage($page, $size)->get();
        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'success');
    }

    /**
     * app版本 添加、编辑
     * @param Request $request
     * @return array
     * @throws DbException
     * @throws ValidatorException
     * @RequestMapping(method={RequestMethod::POST}, route="do_app_version")
     */
    public function do_app_version(Request $request)
    {
        $params = $request->params;
        validate($params, 'SystemValidator', ['type', 'version', 'url', 'is_force', 'remark', 'action_type']);
        if ($params['action_type'] === 'add') {
            $appVersion = AppVersion::new();
        } else {
            $appVersion = AppVersion::find($params['id']);
            if (!$appVersion) {
                return MyQuit::returnMessage(MyCode::PARAM_ERROR, '版本信息不存在');
            }
        }
        $appVersion->setIsForce($params['is_force']);
        $appVersion->setUrl($params['url']);
        $appVersion->setVersion($params['version']);
        $appVersion->setRemark($params['remark']);
        $appVersion->setType($params['type']);
        $res = $appVersion->save();
        if ($res) {
            return MyQuit::returnMessage(MyCode::SUCCESS, 'success');
        }
        return MyQuit::returnMessage(MyCode::SERVER_ERROR, 'server error');
    }

    /**
     * app版本单条数据
     * @param $id
     * @return array
     * @throws DbException
     * @RequestMapping(method={RequestMethod::GET}, route="{id}/get_app_version")
     */
    public function getAppVersion(int $id)
    {
        $data = DB::table('app_version')->where(['id' => $id])->firstArray();
        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'success');
    }

    /**
     * app版本数据删除
     * @param $id
     * @return array
     * @throws DbException
     * @RequestMapping(method={RequestMethod::GET}, route="{id}/del_app_version")
     */
    public function appVersionDel(int $id)
    {
        $res = DB::table('app_version')->where(['id' => $id])->delete();
        if (!$res) {
            return MyQuit::returnMessage(MyCode::SERVER_ERROR, 'server error');
        }
        return MyQuit::returnMessage(MyCode::SUCCESS, 'success');
    }
}
