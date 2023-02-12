<?php


namespace App\Http\Controller;

use App\Lib\MyCode;
use App\Lib\MyQuit;
use App\Model\Data\PaginationData;
use App\Model\Entity\MiningSiteVideo;
use Swoft\Db\DB;
use Swoft\Db\Exception\DbException;
use Swoft\Http\Message\Request;
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
 * Class MiningSiteVideoController
 * @package App\Http\Controller
 * @Controller("/mining_site_video")
 * @Middlewares({
 *     @Middleware(AuthMiddleware::class),
 *     @Middleware(PermissionMiddleware::class)
 * })
 */
class MiningSiteVideoController
{
    /**
     * 矿场视频列表
     * @param Request $request
     * @return mixed
     * @throws DbException
     * @throws Throwable
     * @RequestMapping(method={RequestMethod::GET})
     */
    public function list(Request $request)
    {
        $params = $request->params;
        $page = $params['page'] ?? 1;
        $size = $params['size'] ?? 10;
        $status = $params['status'] ?? '';
        $title = $params['title'] ?? '';
        $where = [];
        if ($status || $status === "0") {
            $where[] = ['status', '=', (int)$status];
        }
        if ($title) {
            $where[] = ['title', 'like', '%' . $title . '%'];
        }
        $data = PaginationData::table('mining_site_video')
            ->where($where)
            ->forPage($page, $size)
            ->orderBy('sort')
            ->get();
        if (!$data) {
            return false;
        }

        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'success');
    }

    /**
     * 矿场视频添加、编辑
     * @param Request $request
     * @return array
     * @throws DbException
     * @throws ValidatorException
     * @RequestMapping(method={RequestMethod::POST})
     */
    public function do_mining_site_video(Request $request)
    {
        $params = $request->params;
        validate($params, 'MiningSiteVideoValidator', ['title', 'url', 'cover_image_url', 'status', 'sort']);

        if ($params['action_type'] === 'add') {
            $miningSiteVideo = MiningSiteVideo::new();
        } else {
            $miningSiteVideo = MiningSiteVideo::find($params['id']);
        }
        $miningSiteVideo->setTitle($params['title']);
        $miningSiteVideo->setUrl($params['url']);
        $miningSiteVideo->setCoverImageUrl($params['cover_image_url']);
        $miningSiteVideo->setStatus($params['status']);
        $miningSiteVideo->setSort($params['sort']);
        $res = $miningSiteVideo->save();
        if ($res) {
            return MyQuit::returnMessage(MyCode::SUCCESS, 'success');
        }
        return MyQuit::returnMessage(MyCode::SERVER_ERROR, 'server error');
    }

    /**
     * 矿场视频单条数据
     * @param $id
     * @return array
     * @throws DbException
     * @RequestMapping(method={RequestMethod::GET}, route="{id}/get")
     */
    public function get(int $id)
    {
        $data = DB::table('mining_site_video')->where(['id' => $id])->firstArray();

        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'success');
    }
}
