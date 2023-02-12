<?php


namespace App\Model\Data;

use ReflectionException;
use Swoft\Bean\Exception\ContainerException;
use Swoft\Db\DB;
use Swoft\Db\Exception\DbException;
use Swoft\Db\Query\Builder;

/**
 * Class ArticleData
 * @package App\Model\Data
 */
class ArticleData
{
    /**
     * 获取文章列表
     * @param $page_index
     * @param $search_key
     * @return array
     * @throws DbException
     */
    public static function get_article_list($page_index, $search_key)
    {
        if (!empty($search_key)) {
            $where = array(
                ['title', 'LIKE', '%'.$search_key.'%'],
                ['type', '!=', 'news']
            );
        } else {
            $where = array(['type', '!=', 'news']);
        }

        $per_num = config('per_page_num');
        $data['info'] = DB::table('article')
            ->leftjoin('admin_user', 'admin_user.id', '=', 'article.assign_to')
            ->leftjoin('article_type', 'article_type.type_code', '=', 'article.type')
            ->leftjoin('lang_type', 'lang_type.type_code', '=', 'article.lang_type')
            ->select('article.*','admin_user.nickname', 'article_type.type_name as type_plain', 'lang_type.type_name as lang_name')
            ->where($where)
            ->orderBy('order_num', 'DESC')
            ->orderBy('create_time', 'DESC')
            ->forPage($page_index, $per_num)
            ->get()
            ->toArray();

        $data['count'] = DB::table('article')->where($where)->count();
        return $data;
    }

    /**
     * 获取文章具有的类型(不含 news)
     * @return array|bool
     * @throws DbException
     */
    public static function get_article_type()
    {
        $data = DB::table('article_type')->where('type_code', '!=', 'news')
            ->get()->toArray();

        if (!$data) {
            return false;
        }
        return $data;
    }

    /**
     * 获取文章具有的语言类型
     * @return array|bool
     * @throws DbException
     */
    public static function get_lang()
    {
        $data = DB::table('lang_type')->where('status', '=', '1')->get()->toArray();

        if (!$data) {
            return false;
        }
        return $data;
    }

    /**
     * 获取对应ID的文章信息
     * @param $id
     * @return bool|Builder
     * @throws DbException
     */
    public static function get_article_info($id)
    {
        $data = DB::table('article')->where('id',$id)->get()->toArray();

        if (!$data) {
            return false;
        }
        return $data[0];
    }

    /**
     * 添加文章
     * @param $info
     * @return bool
     * @throws DbException
     * @throws ReflectionException
     * @throws ContainerException
     */
    public static function add_article($info)
    {
        //添加管理员
        $id = DB::table('article')->insertGetId([
            'title' => $info['title'],
            'content' => $info['content'],
            'type' => $info['type'],
            'lang_type' => $info['lang_type'],
            'status'  => isset($info['status']) ? 1 : 0,
            'is_top'  => isset($info['is_top']) ? 1 : 0,
            'is_red'  => isset($info['is_red']) ? 1 : 0,
            'is_bold'  => isset($info['is_bold']) ? 1 : 0,
            'is_carousel'  => isset($info['is_carousel']) ? 1 : 0,
            'order_num'  => isset($info['order_num']) && !empty($info['order_num']) ? $info['order_num'] : 100,
            'assign_to'  => $info['uid'],
            'create_time'  => empty($info['create_time']) ? time() : strtotime($info['create_time']),
            'update_time'  => time()
        ]);

        if ($id) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 编辑文章
     * @param $info
     * @return bool
     * @throws ContainerException
     * @throws DbException
     * @throws ReflectionException
     */
    public static function edit_article($info)
    {
        $res = DB::table('article')
            ->where('id', $info['id'])
            ->update([
                'title' => $info['title'],
                'content' => $info['content'],
                'type' => $info['type'],
                'lang_type' => $info['lang_type'],
                'status'  => isset($info['status']) ? 1 : 0,
                'is_top'  => isset($info['is_top']) ? 1 : 0,
                'is_red'  => isset($info['is_red']) ? 1 : 0,
                'is_bold'  => isset($info['is_bold']) ? 1 : 0,
                'is_carousel'  => isset($info['is_carousel']) ? 1 : 0,
                'order_num'  => isset($info['order_num']) && !empty($info['order_num']) ? $info['order_num'] : 100,
                'assign_to'  => $info['uid'],
                'create_time'  => empty($info['create_time']) ? time() : strtotime($info['create_time']),
                'update_time'  => time()
            ]);

        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 删除文章/新闻
     * @param $id
     * @return bool
     * @throws ContainerException
     * @throws DbException
     * @throws ReflectionException
     */
    public static function delete_article($id)
    {
        $res = DB::table('article')->where('id', $id)->delete();

        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 修改文章/新闻置顶状态
     * @param $id
     * @param $top
     * @return bool
     * @throws ContainerException
     * @throws DbException
     * @throws ReflectionException
     */
    public static function edit_article_top($id, $top)
    {
        $res = DB::table('article')->where('id', $id)->update(['is_top'=> $top]);

        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 修改文章/新闻轮播状态
     * @param $id
     * @param $carousel
     * @return bool
     * @throws ContainerException
     * @throws DbException
     * @throws ReflectionException
     */
    public static function edit_article_carousel($id, $carousel)
    {
        $res = DB::table('article')->where('id', $id)->update(['is_carousel'=> $carousel]);

        if ($res) {
            return true;
        } else {
            return false;
        }
    }
}
