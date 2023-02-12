<?php

namespace App\Http\Controller;

use App\Lib\MyCode;
use App\Lib\MyCommon;
use App\Lib\MyGA;
use App\Lib\MyQuit;
use App\Model\Data\CoinData;
use App\Model\Data\RolesData;
use App\Model\Entity\AdminUsers;
use App\Rpc\Lib\FileTokenInterface;
use Swoft\Bean\Annotation\Mapping\Inject;
use Swoft\Db\DB;
use Swoft\Http\Message\Request;
use Swoft\Db\Exception\DbException;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\Middleware;
use Swoft\Http\Server\Annotation\Mapping\Middlewares;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;
use Swoft\Rpc\Client\Annotation\Mapping\Reference;
use Swoft\Validator\Exception\ValidatorException;
use App\Http\Middleware\AuthMiddleware;

/**
 * Class CommonController
 * @package App\Http\Controller
 * @Controller("/common")
 * @Middlewares({
 *     @Middleware(AuthMiddleware::class),
 * })
 */
class CommonController
{
    /**
     * @Inject()
     * @var MyGA
     */
    private $myGa;

    /**
     * @Reference(pool="system.pool")
     * @var FileTokenInterface
     */
    private $fileToken;

    /**
     * 获取谷歌验证二维码链接
     * @param Request $request
     * @return array
     * @throws ValidatorException
     * @RequestMapping(method={RequestMethod::GET})
     */
    public function google_auth_qrcode(Request $request)
    {
        $params = $request->params;
        $params = validate($params, 'AccountValidator', ['user_name', 'secret']);
        $qrCodeUrl = $this->myGa->getQRCodeGoogleUrl('btsw.' . $params['user_name'], $params['secret']);
        $data = ['qrcode' => $qrCodeUrl];
        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'success');
    }

    /**
     * 获取可以使用的上级角色列表
     * @return array
     * @throws DbException
     * @RequestMapping(method={RequestMethod::GET})
     */
    public function superior()
    {
        $data = RolesData::superior_roles();
        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'success');
    }

    /**
     * 修改密码
     * @param Request $request
     * @return array
     * @throws DbException
     * @throws ValidatorException
     * @RequestMapping(method={RequestMethod::PUT})
     */
    public function update_user_password(Request $request)
    {
        $params = $request->params;
        //验证
        validate($params, 'AccountValidator', ['password_old', 'password_new']);
        $user = AdminUsers::find($request->uid);//makeVisible
        if (!password_verify($params['password_old'], $user->getPassword())) {
            return MyQuit::returnMessage(MyCode::PASSWORD_ERROR, '旧密码错误');
        }
        if ($params['password_new'] === $params['password_old']) {
            return MyQuit::returnMessage(MyCode::PARAM_ERROR, '新旧密码一致');
        }
        $user->setPassword(MyCommon::create_user_password($params['password_new']));
        $result = $user->save();
        if ($result) {
            return MyQuit::returnMessage(MyCode::SUCCESS, '修改成功');
        }
        return MyQuit::returnMessage(MyCode::SERVER_ERROR, '失败');

    }

    /**
     * 修改用户信息
     * @param Request $request
     * @return array
     * @throws DbException
     * @throws ValidatorException
     * @RequestMapping(method={RequestMethod::PUT})
     */
    public function update_user_info(Request $request)
    {
        $params = $request->params;
        validate($params, 'AccountValidator', ['email']);
        $user = AdminUsers::find($request->uid);
        $user->setEmail($params['email']);
        $result = $user->save();
        if ($result) {
            return MyQuit::returnMessage(MyCode::SUCCESS, '修改成功');
        }
        return MyQuit::returnMessage(MyCode::SERVER_ERROR, '失败');

    }

    /**
     * 获取币种名称列表
     * @throws DbException
     * @RequestMapping(method={RequestMethod::GET})
     */
    public function coin_list()
    {
        $coins = CoinData::get_coins();
        $data = [];
        foreach ($coins as $coin) {
            $data[] = [
                'coin_id'   => $coin['id'],
                'coin_name' => $coin['coin_name_en']
            ];
        }
        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'success');
    }

    /**
     * 获取可上下分的操作类型
     * @return array
     * @RequestMapping(method={RequestMethod::GET})
     * @throws DbException
     */
    public function trade_type(Request $request)
    {
        $params = $request->params;
        validate($params, 'UserValidator', ['wallet_type']);
        if (isset($params['show_type']) && $params['show_type'] === 'all') {
            $where = [];
        } else {
            $where = ['show_type' => $params['show_type']];
        }
        $table_name = 'trade_type_' . $params['wallet_type'];
        $data = DB::table($table_name)->where($where)->get()->toArray();;
        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'success');
    }

    /**
     * 获取上传图片token
     * @return array
     * @RequestMapping(method={RequestMethod::GET})
     */
    public function get_file_token()
    {
        $token = $this->fileToken->generate_token();
        return MyQuit::returnSuccess(['upToken' => $token], MyCode::SUCCESS, 'success');
    }

    /**
     * 文章可用语言类型列表
     * @return array
     * @throws DbException
     * @RequestMapping(method={RequestMethod::GET})
     */
    public function lang_type_list()
    {
        $data = DB::table('lang_type')
            ->select('type_code', 'type_name')
            ->where(['status' => 1])
            ->get()
            ->toArray();

        return MyQuit::returnSuccess($data, MyCode::SUCCESS, 'success');
    }

}
