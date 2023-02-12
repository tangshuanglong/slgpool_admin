<?php
namespace App\Http\Controller;

use App\Lib\MyCode;
use App\Lib\MyQuit;
use App\Model\Data\PaginationData;
use App\Model\Entity\NewsType;
use Swoft\Db\DB;
use Swoft\Db\Exception\DbException;
use Swoft\Http\Message\Request;
use Swoft\Validator\Exception\ValidatorException;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\Middleware;
use Swoft\Http\Server\Annotation\Mapping\Middlewares;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\PermissionMiddleware;

/**
 * Class NewsTypeController
 * @package App\Http\Controller
 * @Controller("/news_type")
 * @Middlewares({
 *     @Middleware(AuthMiddleware::class),
 *     @Middleware(PermissionMiddleware::class)
 * })
 */
class NewsTypeController
{
    /**
     * 资讯可用类型列表
     * @return array
     * @throws DbException
     * @RequestMapping(method={RequestMethod::GET})
     */
    public function news_type_list()
    {
        $data = DB::table('news_type')
            ->select('type_code', 'type_name')
            ->where(['status' => 1])
            ->orderBy('order_num', 'desc')
            ->get()
            ->toArray();
        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'success');
    }

    /**
     * 资讯类型列表
     * @param Request $request
     * @return mixed
     * @throws DbException
     * @RequestMapping(method={RequestMethod::GET})
     */
    public function list(Request $request)
    {
        $params = $request->get();
        $page = $params['page'] ?? 1;
        $size = $params['size'] ?? 10;
        $data = PaginationData::table('news_type')
            ->forPage($page, $size)
            ->orderBy('order_num', 'desc')
            ->get();
        if (!$data) {
            return false;
        }
        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'success');
    }

    /**
     * 资讯类型添加、编辑
     * @param Request $request
     * @return array
     * @throws DbException
     * @throws ValidatorException
     * @RequestMapping(method={RequestMethod::POST})
     */
    public function do_news_type(Request $request)
    {
        $params = $request->post();
        if ($params['action_type'] === 'add') {
            $model = NewsType::new();
            //判断是否重复
            $exists = NewsType::where(['type_code' => $params['type_code']])->exists();
            if($exists){
                return MyQuit::returnMessage(MyCode::PARAM_ERROR, '参数错误');
            }
        } else {
            $model = NewsType::find($params['id']);
            //判断是否重复
            $where = [
                ['type_code', '=', $params['type_code']],
                ['id', '<>', $params['id']]
            ];
            $exists = NewsType::where($where)->exists();
            if($exists){
                return MyQuit::returnMessage(MyCode::PARAM_ERROR, '参数错误');
            }
        }
        $model->setTypeCode($params['type_code']);
        $model->setTypeName($params['type_name']);
        $model->setStatus($params['status']);
        $model->setDisplayStatus($params['display_status']);
        $model->setOrderNum($params['order_num']);
        if ($model->save()) {
            return MyQuit::returnMessage(MyCode::SUCCESS, 'success');
        }
        return MyQuit::returnMessage(MyCode::SERVER_ERROR, 'server error');
    }

    /**
     * 资讯类型单条数据
     * @param $id
     * @return array
     * @throws DbException
     * @RequestMapping(method={RequestMethod::GET}, route="{id}/get")
     */
    public function get(int $id)
    {
        $data = DB::table('news_type')->where(['id' => $id])->firstArray();
        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'success');
    }

    /**
     * 资讯类型删除
     * @param int $id
     * @return array
     * @throws DbException
     * @RequestMapping(method={RequestMethod::POST}, route="del/{id}")
     */
    public function del(int $id)
    {
        $params['id'] = $id;
        if (isset($params['id']) && is_int($params['id'])) {
            $news_type = NewsType::find($params['id']);
            if ($news_type->delete()) {
                return MyQuit::returnMessage(MyCode::SUCCESS, 'success');
            } else {
                return MyQuit::returnMessage(MyCode::SERVER_ERROR, '未找到资讯类型');
            }
        } else {
            return MyQuit::returnMessage(MyCode::SERVER_ERROR, '未找到资讯类型');
        }
    }

}
