<?php
namespace App\Http\Controller;

use App\Lib\MyCode;
use App\Lib\MyCommon;
use App\Lib\MyQuit;
use App\Model\Data\PaginationData;
use App\Model\Entity\Article;
use App\Model\Entity\ArticleType;
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
 * Class ArticleController
 * @package App\Http\Controller
 * @Controller("/article")
 * @Middlewares({
 *     @Middleware(AuthMiddleware::class),
 *     @Middleware(PermissionMiddleware::class)
 * })
 */
class ArticleController
{

    /**
     * @Reference(pool="system.pool")
     *
     * @var JPushInterface
     */
    private $jPushService;

    /**
     * 文章列表
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
        $type = $params['type'] ?? '';
        $langType = $params['lang_type'] ?? '';

        $where = [];
        if ($title) {
            $where[] = ['title', 'like', '%' . $title . '%'];
        }
        if ($status || $status === "0") {
            $where[] = ['status', '=', (int)$status];
        }
        if ($type) {
            $where[] = ['type', '=', $type];
        }
        if ($langType) {
            $where[] = ['lang_type', '=', $langType];
        }

        $data = PaginationData::table('article')
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
     * 文章添加、编辑
     * @param Request $request
     * @return array
     * @throws DbException
     * @throws ValidatorException
     * @RequestMapping(method={RequestMethod::POST})
     */
    public function do_article(Request $request)
    {
        $params = $request->params;
        validate($params, 'ArticleValidator', ['title', 'thumbnail', 'content', 'type', 'status', 'order_num', 'lang_type']);

        // 验证文章类型是否存在
        if (!ArticleType::where(['type_code' => $params['type']])->firstArray()) {
            return MyQuit::returnMessage(MyCode::SERVER_ERROR, '文章类型不存在');
        }

        // 验证语言类型是否存在
        if (!LangType::where(['type_code' => $params['lang_type']])->firstArray()) {
            return MyQuit::returnMessage(MyCode::SERVER_ERROR, '语言类型不存在');
        }

        // 关于我们文章，只允许创建一条启用
        if ($params['type'] === 'about_us' && $params['action_type'] === 'add' && $params['status'] === 1) {
            if (Article::where(['type' => 'about_us', 'status' => 1])->firstArray()) {
                return MyQuit::returnMessage(MyCode::SERVER_ERROR, '关于我们只允许一条启用');
            }
        } elseif ($params['type'] === 'about_us' && $params['action_type'] === 'edit' && $params['status'] === 1) {
            $where = [['type', '=', 'about_us'], ['status', '=', 1], ['id', '!=', $params['id']]];
            if (Article::where($where)->firstArray()) {
                return MyQuit::returnMessage(MyCode::SERVER_ERROR, '关于我们只允许一条启用');
            }
        }

        if($params['thumbnail']){
            $thumbnail = MyCommon::get_filename($params['thumbnail']);
            if (!$thumbnail) {
                return MyQuit::returnMessage(MyCode::PARAM_ERROR, '图片路径错误');
            }
        }else{
            $thumbnail = '';
        }

        if ($params['action_type'] === 'add') {
            $article = Article::new();
        } else {
            $article = Article::find($params['id']);
        }

        $article->setTitle($params['title']);
        $article->setThumbnail($thumbnail);
        $article->setSummary($params['summary']);
        $article->setContent($params['content']);
        $article->setAssignTo($request->uid);
        $article->setStatus($params['status']);
        $article->setIsPushed($params['is_pushed'] ?? 0);
        $article->setType($params['type']);
        $article->setOrderNum($params['order_num']);
        $article->setLangType($params['lang_type']);

        if ($article->save()) {
            return MyQuit::returnMessage(MyCode::SUCCESS, 'success');
        }
        return MyQuit::returnMessage(MyCode::SERVER_ERROR, 'server error');
    }

    /**
     * 文章单条数据
     * @param $id
     * @return array
     * @throws DbException
     * @RequestMapping(method={RequestMethod::GET}, route="{id}/get")
     */
    public function get(int $id)
    {
        $data = DB::table('article')->where(['id' => $id])->firstArray();
        if ($data) {
            if (!empty($data['thumbnail'])) {
                $data['thumbnail'] = MyCommon::get_filepath($data['thumbnail']);
            }
        }
        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'success');
    }

    /**
     * 文章删除
     * @param int $id
     * @return array
     * @throws DbException
     * @RequestMapping(method={RequestMethod::POST}, route="del/{id}")
     */
    public function del(int $id)
    {
        $params['id'] = $id;
        if (isset($params['id']) && is_int($params['id'])) {
            $article = Article::find($params['id']);
            if ($article->delete()) {
                return MyQuit::returnMessage(MyCode::SUCCESS, 'success');
            } else {
                return MyQuit::returnMessage(MyCode::SERVER_ERROR, '未找到文章');
            }
        } else {
            return MyQuit::returnMessage(MyCode::SERVER_ERROR, '未找到文章');
        }
    }

    /**
     * 文章推送
     * @param int $id
     * @return array
     * @throws DbException
     * @RequestMapping(method={RequestMethod::PUT}, route="{id}/article_push")
     */
    public function article_push(int $id)
    {
        // 获取文章，组装推送数据
        $article = DB::table('article')->where(['id' => $id])->firstArray();

        // 调用RPC接口，推送文章
        $pushResult = $this->jPushService->pushToAll($article['title'], $article['content']);
        if (!$pushResult) {
            return MyQuit::returnMessage(MyCode::SERVER_ERROR, '推送出现错误');
        }

        // 将文章设置为已推送状态
        $res = Article::find($id)->setIsPushed(1)->save();
        if (!$res) {
            return MyQuit::returnMessage(MyCode::SERVER_ERROR, '文章推送状态更改失败');
        }

        return MyQuit::returnMessage(MyCode::SUCCESS, 'success');
    }
}
