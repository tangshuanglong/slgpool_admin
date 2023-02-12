<?php

namespace App\Http\Controller;

use App\Lib\MyCode;
use App\Lib\MyCommon;
use App\Lib\MyQuit;
use App\Model\Data\PaginationData;
use App\Model\Entity\News;
use App\Model\Entity\NewsType;
use App\Model\Entity\LangType;
use App\Rpc\Lib\JPushInterface;
use Swoft\Db\DB;
use Swoft\Db\Exception\DbException;
use Swoft\Http\Message\Request;
use Swoft\Rpc\Client\Annotation\Mapping\Reference;
use Swoft\Validator\Exception\ValidatorException;
use Throwable;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\Middleware;
use Swoft\Http\Server\Annotation\Mapping\Middlewares;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\PermissionMiddleware;

/**
 * Class NewsController
 * @package App\Http\Controller
 * @Controller("/news")
 * @Middlewares({
 *     @Middleware(AuthMiddleware::class),
 *     @Middleware(PermissionMiddleware::class)
 * })
 */
class NewsController
{
    /**
     * 资讯列表
     * @param Request $request
     * @return mixed
     * @throws DbException
     * @RequestMapping(method={RequestMethod::GET})
     */
    public function list(Request $request)
    {
        $params = $request->params;
        $page = $params['page'] ?? 1;
        $size = $params['size'] ?? 10;
        $title = $params['title'] ?? '';
        $status = $params['status'] ?? '';
        $news_type = $params['news_type'] ?? '';
        $type = $params['type'] ?? '';
        $is_featured = $params['is_featured'] ?? '';
        $langType = $params['lang_type'] ?? '';
        $where = [];
        if ($title) {
            $where[] = ['title', 'like', '%' . $title . '%'];
        }
        if ($status || $status === "0") {
            $where[] = ['status', '=', (int)$status];
        }
        if ($news_type) {
            $where[] = ['news_type', '=', $news_type];
        }
        if ($type) {
            $where[] = ['type', '=', $type];
        }
        if ($is_featured) {
            $where[] = ['is_featured', '=', $is_featured];
        }
        if ($langType) {
            $where[] = ['lang_type', '=', $langType];
        }
        $data = PaginationData::table('news')
            ->where($where)
            ->forPage($page, $size)
            ->orderBy('order_num', 'desc')
            ->get();
        if (!$data) {
            return false;
        }
        foreach ($data['list'] as $key => $val) {
            $data['list'][$key]['thumbnail'] = MyCommon::get_filepath($val['thumbnail']);
        }

        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'success');
    }

    /**
     * 资讯添加、编辑
     * @param Request $request
     * @return array
     * @throws DbException
     * @throws ValidatorException
     * @RequestMapping(method={RequestMethod::POST})
     */
    public function do_news(Request $request)
    {
        $params = $request->params;
        validate($params, 'NewsValidator', ['title', 'thumbnail', 'content', 'news_type', 'type', 'status', 'lang_type', 'is_featured', 'order_num', 'action_type']);
        // 验证资讯类型是否存在
        if (!NewsType::where(['type_code' => $params['type']])->firstArray()) {
            return MyQuit::returnMessage(MyCode::SERVER_ERROR, '资讯类型不存在');
        }
        // 验证语言类型是否存在
        if (!LangType::where(['type_code' => $params['lang_type']])->firstArray()) {
            return MyQuit::returnMessage(MyCode::SERVER_ERROR, '语言类型不存在');
        }
        if (!empty($params['thumbnail'])) {
            $thumbnail = MyCommon::get_filename($params['thumbnail']);
            if (!$thumbnail) {
                return MyQuit::returnMessage(MyCode::PARAM_ERROR, '图片路径错误');
            }
        } else {
            $thumbnail = '';
        }
        if ($params['action_type'] === 'add') {
            $model = News::new();
        } else {
            $model = News::find($params['id']);
        }
        //快讯非精选
        if($params['news_type'] == 'news_type'){
            $params['is_featured'] = 2;
        }
        $model->setTitle($params['title']);
        $model->setThumbnail($thumbnail);
        $model->setSummary($params['summary']);
        $model->setContent($params['content']);
        $model->setNewsType($params['news_type']);
        $model->setType($params['type']);
        $model->setAssignTo($request->uid);
        $model->setIsFeatured($params['is_featured']);
        $model->setStatus($params['status']);
        $model->setLangType($params['lang_type']);
        $model->setOrderNum($params['order_num']);
        if ($model->save()) {
            return MyQuit::returnMessage(MyCode::SUCCESS, 'success');
        }
        return MyQuit::returnMessage(MyCode::SERVER_ERROR, 'server error');
    }

    /**
     * 资讯单条数据
     * @param $id
     * @return array
     * @throws DbException
     * @RequestMapping(method={RequestMethod::GET}, route="{id}/get")
     */
    public function get(int $id)
    {
        $data = DB::table('news')->where(['id' => $id])->firstArray();
        if ($data) {
            if (!empty($data['thumbnail'])) {
                $data['thumbnail'] = MyCommon::get_filepath($data['thumbnail']);
            }
        }
        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'success');
    }

    /**
     * 资讯删除
     * @param int $id
     * @return array
     * @throws DbException
     * @RequestMapping(method={RequestMethod::POST}, route="del/{id}")
     */
    public function del(int $id)
    {
        $params['id'] = $id;
        if (isset($params['id']) && is_int($params['id'])) {
            $model = News::find($params['id']);
            if ($model->delete()) {
                return MyQuit::returnMessage(MyCode::SUCCESS, 'success');
            } else {
                return MyQuit::returnMessage(MyCode::SERVER_ERROR, '未找到资讯');
            }
        } else {
            return MyQuit::returnMessage(MyCode::SERVER_ERROR, '未找到资讯');
        }
    }

}
