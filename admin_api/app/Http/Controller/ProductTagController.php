<?php

namespace App\Http\Controller;

use App\Lib\MyCode;
use App\Lib\MyCommon;
use App\Lib\MyQuit;
use App\Model\Data\PaginationData;
use App\Model\Entity\BzzProduct;
use App\Model\Entity\ChiaProduct;
use App\Model\Entity\PowerProduct;
use App\Model\Entity\ProductTag;
use App\Rpc\Lib\KlineInterface;
use Swoft\Db\DB;
use Swoft\Db\Exception\DbException;
use Swoft\Http\Message\Request;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\Middleware;
use Swoft\Http\Server\Annotation\Mapping\Middlewares;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Redis\Redis;
use Swoft\Rpc\Client\Annotation\Mapping\Reference;
use Swoft\Validator\Exception\ValidatorException;
use Throwable;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\PermissionMiddleware;

/**
 * Class ProductTagController
 * @package App\Http\Controller
 * @Controller("/product_tag")
 * @Middlewares({
 *     @Middleware(AuthMiddleware::class),
 *     @Middleware(PermissionMiddleware::class)
 * })
 */
class ProductTagController
{
    /**
     * 所有标签列表
     * @param Request $request
     * @return mixed
     * @throws DbException
     * @throws Throwable
     * @RequestMapping(method={RequestMethod::GET})
     */
    public function all(Request $request)
    {
        $data = DB::table('product_tag')->orderBy('order_num', 'desc')->get();

        return MyQuit::returnSuccess($data->toArray(), MyCode::SUCCESS, 'success');
    }

    /**
     * 标签列表
     * @param Request $request
     * @return mixed
     * @throws DbException
     * @throws Throwable
     * @RequestMapping(method={RequestMethod::GET})
     */
    public function list(Request $request)
    {
        $params = $request->get();
        $page = $params['page'] ?? 1;
        $size = $params['size'] ?? 10;
        $data = PaginationData::table('product_tag')
            ->forPage($page, $size)
            ->orderBy('order_num', 'desc')
            ->get();
        if (!$data) {
            return MyQuit::returnMessage(MyCode::SERVER_ERROR, 'server error');
        }
        foreach ($data['list'] as $key => $val) {
            $data['list'][$key]['url'] = MyCommon::get_filepath($val['url']);
        }

        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'success');
    }

    /**
     * 标签添加、编辑
     * @param Request $request
     * @return array
     * @throws DbException
     * @throws ValidatorException
     * @RequestMapping(method={RequestMethod::POST})
     */
    public function do(Request $request)
    {
        $params = $request->post();
        //validate($params, 'ProductValidator');

        if ($params['action_type'] === 'add') {
            $product = ProductTag::new();
        } else {
            $product = ProductTag::find($params['id']);
        }
        $url = MyCommon::get_filename($params['url']);
        if (!$url) {
            return MyQuit::returnMessage(MyCode::PARAM_ERROR, '图片路径错误');
        }
        $product->setName($params['name']);
        $product->setUrl($url);
        $product->setOrderNum($params['order_num']);
        $res = $product->save();
        if ($res) {
            return MyQuit::returnMessage(MyCode::SUCCESS, 'success');
        }
        return MyQuit::returnMessage(MyCode::SERVER_ERROR, 'server error');
    }

    /**
     * 标签单条数据
     * @param $id
     * @return array
     * @throws DbException
     * @RequestMapping(method={RequestMethod::GET}, route="{id}/get")
     */
    public function get(int $id)
    {
        $data = DB::table('product_tag')->where(['id' => $id])->firstArray();
        if ($data) {
            if (!empty($data['url'])) {
                $data['url'] = MyCommon::get_filepath($data['url']);
            }
        }
        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'success');
    }

    /**
     * 标签删除
     * @param int $id
     * @return array
     * @throws DbException
     * @RequestMapping(method={RequestMethod::POST}, route="del/{id}")
     */
    public function del(int $id)
    {
        $params['id'] = $id;
        if (isset($params['id']) && is_int($params['id'])) {
            $tag = ProductTag::find($params['id']);
            //查询标签是否存在
            $tag_exists = PowerProduct::whereRaw('FIND_IN_SET(:tag_ids, product_tag_ids)', ['tag_ids' => $params['id']])->exists();
            if($tag_exists){
                return MyQuit::returnMessage(MyCode::SERVER_ERROR, 'fil产品存在该标签');
            }
            $tag_exists = ChiaProduct::whereRaw('FIND_IN_SET(:tag_ids, product_tag_ids)', ['tag_ids' => $params['id']])->exists();
            if($tag_exists){
                return MyQuit::returnMessage(MyCode::SERVER_ERROR, 'chia产品存在该标签');
            }
            $tag_exists = BzzProduct::whereRaw('FIND_IN_SET(:tag_ids, product_tag_ids)', ['tag_ids' => $params['id']])->exists();
            if($tag_exists){
                return MyQuit::returnMessage(MyCode::SERVER_ERROR, 'swarm产品存在该标签');
            }
            if ($tag->delete()) {
                return MyQuit::returnMessage(MyCode::SUCCESS, 'success');
            } else {
                return MyQuit::returnMessage(MyCode::SERVER_ERROR, '未找到标签');
            }
        } else {
            return MyQuit::returnMessage(MyCode::SERVER_ERROR, '未找到标签');
        }
    }

}
