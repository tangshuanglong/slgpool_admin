<?php declare(strict_types=1);

namespace App\Http\Controller;

use App\Lib\MyToken;
use Swoft\Db\DB;
use Swoft\Http\Message\Response;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;
use Swoft\Http\Message\Request;
use Swoft\Redis\Redis;
use Swoft\Bean\Annotation\Mapping\Inject;
use App\Lib\MyQuit;
use App\Lib\MyCode;
use App\Lib\MyCommon;
use App\Lib\MyGA;

/**
 * Class AuthController
 * @package App\Http\Controller
 *
 * Author j
 * Date 2020/07/16
 *
 * @Controller(prefix="/auth")
 */
class AuthController
{

    /**
     * @Inject()
     * @var MyGA
     */
    private $myGa;

    /**
     * @Inject()
     * @var MyToken
     */
    private $myToken;

    /**
     * @Inject()
     * @var MyCommon
     */
    private $myCommon;

    /**
     * 登录
     * @param Request $request
     * @param Response $response
     * @return Response
     * @throws \Swoft\Db\Exception\DbException
     * @throws \Swoft\Validator\Exception\ValidatorException
     * @RequestMapping(method={RequestMethod::POST})
     */
    public function login(Request $request, Response $response)
    {
        $params = $request->post();
        validate($params, 'AuthValidator', ['user_name', 'password', 'code']);
        $key = config('login_error_key') . $params['user_name'];
        if (Redis::get($key) >= config('login_error_times')) {
            return $response->withData(MyQuit::returnMessage(MyCode::FAIL, '多次登录失败，请稍后重试'));
        }
        $field = 'user_name';
        if ($this->myCommon->is_email($params['user_name'])) {
            $field = 'email';
        }
        $user = DB::table('admin_users')->where([$field => $params['user_name']])->firstArray();
        //验证密码
        if (!$user || !password_verify($params['password'], $user['password'])) {
            Redis::incr($key);
            Redis::expire($key, 600);
            return $response->withData(MyQuit::returnMessage(MyCode::PASSWORD_ERROR, '用户名或密码错误'));
        }
        if ($user['status'] == 0) {
            return $response->withData(MyQuit::returnMessage(MyCode::FORBBIDEN, '用户被禁用，请联系管理员'));
        }
        //验证谷歌验证码
        if (env('APP_DEBUG') != 1) {
            if (!$this->myGa->verifyCode($user['google_auth_code'], $params['code'], 2)) {
                return $response->withData(MyQuit::returnMessage(MyCode::CAPTCHA, '谷歌验证码错误'));
            }
        }
        //成功登录token
        $token = $this->myToken->generateToken($user['user_id'], $params['user_name']);
        if ($token) {
            unset($user['password'], $user['google_auth_code']);
            Redis::del($key);
            return $response->withHeader('Authorization', $token)->withData(MyQuit::returnSuccess($user, MyCode::SUCCESS, '登录成功'));
        }
        return $response->withData(MyQuit::returnMessage(MyCode::SERVER_ERROR, '服务器错误'));
    }


}
