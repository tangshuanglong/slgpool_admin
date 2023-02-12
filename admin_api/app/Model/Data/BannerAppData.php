<?php


namespace App\Model\Data;


use ReflectionException;
use Swoft\Bean\Exception\ContainerException;
use Swoft\Db\DB;
use Swoft\Db\Exception\DbException;

class BannerAppData
{
    /**
     * 获取图片列表
     * @param int $page_index
     * @return bool|array
     * @throws DbException
     */
    public static function get_app_banner_list(int $page_index)
    {
        $per_num = config('per_page_num');
        $banner = DB::table('img_banner_app')
            ->leftJoin('lang_type', 'lang_type.type_code', '=', 'img_banner_app.lang_type')
            ->select('img_banner_app.*', 'lang_type.type_name')
            ->orderBy('status', 'DESC')
            ->orderBy('order_number', 'ASC')
            ->forPage($page_index, $per_num)
            ->get()
            ->toArray();

        if (!$banner) {
            return false;
        }

        $data['info'] = $banner;
        $data['count'] = DB::table('img_banner_app')->count();
        return $data;
    }

    /**
     * 获取图片信息
     * @param $id
     * @return array|bool
     * @throws DbException
     */
    public static function get_banner_info($id)
    {
        $banner = DB::table('img_banner_app')
            ->leftJoin('lang_type', 'lang_type.type_code', '=', 'img_banner_app.lang_type')
            ->select('img_banner_app.*', 'lang_type.type_name')
            ->where('img_banner_app.id', $id)
            ->get()
            ->toArray();

        if (!$banner) {
            return false;
        }
        return $banner[0];
    }

    /**
     * 判断排序号是否已存在
     * @param $order_number
     * @param $id
     * @return bool
     * @throws DbException
     * @throws ContainerException
     * @throws ReflectionException
     */
    public static function find_order_number($order_number, $id = "")
    {
        if (empty($id)) {
            $res = DB::table('img_banner_app')
                ->where('order_number', $order_number)
                ->exists();
        } else {
            $res = DB::table('img_banner_app')
                ->where([
                    'order_number' => $order_number,
                    ['id', '!=', $id]
                ])
                ->exists();
        }

        return $res;
    }

    /**
     * 添加图片
     * @param $info
     * @return string
     * @throws ContainerException
     * @throws DbException
     * @throws ReflectionException
     */
    public static function add_banner($info)
    {
        $res = DB::table('img_banner_app')
            ->insertGetId([
                'order_number' => $info['order_number'],
                'img_src' => $info['img_src'],
                'link_href' => $info['pc_link_href'],
                'content' => $info['content'],
                'status' => $info['status'],
                'lang_type' => $info['lang_type'],
                'create_time' => time()
            ]);

        return $res;
    }

    /**
     * 编辑图片
     * @param $info
     * @return int
     * @throws ContainerException
     * @throws DbException
     * @throws ReflectionException
     */
    public static function edit_banner($info)
    {
        $res = DB::table('img_banner_app')
            ->where('id', $info['id'])
            ->update([
                'order_number' => $info['order_number'],
                'img_src' => $info['img_src'],
                'link_href' => $info['pc_link_href'],
                'content' => $info['content'],
                'status' => $info['status'],
                'lang_type' => $info['lang_type'],
                'create_time' => time()
            ]);

        return $res;
    }

    /**
     * 删除图片
     * @param $id
     * @return int
     * @throws ContainerException
     * @throws DbException
     * @throws ReflectionException
     */
    public static function delete_banner($id)
    {
        $res = DB::table('img_banner_app')
            ->where('id', $id)
            ->delete();

        return $res;
    }
}
