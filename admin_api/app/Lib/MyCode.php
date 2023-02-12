<?php

namespace App\Lib;

/**
 * 返回状态码类
 */
class MyCode {

    /**
     *   功能模块状态码
     *   基础类别状态码为0000-1000，统一4位，不足4位前面补零
     *   法币交易功能状态码为2000-2999
     *   币币交易功能状态码为3000-3999
     *   用户信息功能状态码为4000-4999
     *   登录，注册，修改密码，google验证码，二步登录，交易密码等安全类别统一用5000-5999
     *   其他功能类别统一用7000-7999
     *   8000以后的留着备用，以后有后续功能可以往后添加
     **/

    //基础类别状态码

    /**
     * 服务器错误
     */
    CONST SERVER_ERROR = '0001';

    /**
     * 版本错误
     */
    CONST VERSION_ERROR = '0002';

    /**
     * 缺少参数
     */
    CONST LACK_PARAM = '0003';

    /**
     * 被禁止
     */
    CONST FORBBIDEN = '0004';

    /**
     * 参数错误
     */
    CONST PARAM_ERROR = '0005';

    /**
     *数据格式错误
     */
    CONST DATA_FORMAT_ERROR = '0006';

    /**
     *请求方式错误
     */
    CONST METHOD_NOT_ALLOWED = '0007';

    /**
     *请求频繁
     */
    CONST FREPUENT_REQUEST = '0008';

    /**
     *  操作有误
     */
    CONST OPERATE_ERROR = '0009';

    /**
     *  余额不足
     */
    CONST BALANCE_ERROR = '0010';


    /**
     *  未实名认证
     */
    CONST NO_CERTIFICATION = '0012';

    /**
     *  交易密码不正确
     */
    CONST PAYPWD_ERROR = '0013';

    /**
     * 输入交易密码
     */
    CONST TRADE_PWD = '0014';

    /**
     * 处于队列中
     */
    CONST IN_LIST = '0015';

    /**
     * 图片地址错误
     */
    CONST PICTURE_ADDRESS_ERROR = '0016';

    /**
     *  操作过期
     */
    CONST OPERATE_EXPIRE = '0017';



    #########################法币交易状态码#############################

    /**
     * 没有匹配的挂单
     */
    CONST MATCH_ERROR = '2000';

    /**
     *  您有一笔进行中的订单
     */
    CONST OPERATE_ORDER = '2001';

    /**
     *  下单数量必须大于100
     */
    CONST DO_ORDER_NUM = '2003';

    /**
     *  挂单交易数量不足
     */
    CONST C2C_TRADE_AMOUNT_ERROR = '2005';

    /**
     *  挂单最小交易额度错误
     */
    CONST MIN_TRADE_AMOUNT_ERROR = '2006';

    /**
     *  挂单最大交易额度错误
     */
    CONST MAX_TRADE_AMOUNT_ERROR = '2007';

    /**
     * 该用户非商家
     */
    CONST USER_NOT_VENDOR = '2008';

    /**
     * 该商家已存在一笔同类型的挂单
     */
    CONST VENDOR_SAME_PENDING = '2009';

    /**
     * 用户下单成功
     */
    CONST USER_C2C_SUCCESS = '2010';

    /**
     * 用户撤单成功
     */
    CONST USER_C2C_CANCEL = '2011';

    /**
     * 商家下单成功
     */
    CONST VENDOR_C2C_SUCCESS = '2012';

    /**
     * 商家撤单成功
     */
    CONST VENDOR_C2C_CANCEL = '2013';

    /**
     * 用户下单成功商家提示
     */
    CONST USER_C2C_TO_VENDOR = '2014';

    /**
     * 用户撤单成功商家提示
     */
    CONST USER_CANCEL_TO_VENDOR = '2015';


    /**
     * 用户付款商家提示
     */
    CONST USER_TRADE_TO_VENDOR = '2018';

    /**
     * 商家收款用户提示
     */
    CONST VENDOR_TRADE_TO_USER = '2019';

    /**
     * 商家确认付款
     */
    CONST VENDOR_CONFIRM_SUP = '2020';

    /**
     * 商家付款用户提示
     */
    CONST VENDOR_SUP_TO_USER = '2021';

    /**
     * 商家挂单成功
     */
    CONST VENDOR_PENDING_SUCCESS = '2022';

    /**
     * 后台审核通过通知用户
     */
    CONST AUDIT_SUCCESS_TO_USER = '2023';

    /**
     * 后台审核通过通知商家
     */
    CONST AUDIT_SUCCESS_TO_VENDOR = '2024';

    /**
     * 后台撤销订单
     */
    CONST ADMIN_C2C_CANCEL = '2026';


    /**
     *  商家昵称已存在
     */
    CONST DUPLICATION_OF_NICKNAME = '2028';

    /**
     *  您已经是商家
     */
    CONST DUPLICATION_OF_REGISTER_VENDOR = '2029';

    /**
     *  认证等待审核中或已通过审核
     */
    CONST DUPLICATION_OF_VENDOR_AUTH = '2030';

    /**
     *  禁止商家行为
     */
    CONST DENY_VENDOR = '2031';

    /**
     *  余额不足
     */
    CONST NOT_SUFFICIENT_FUNDS = '2035';


    /**
     * 未绑定手机号
     */
    CONST NO_BIND_MOBILE = '2038';


    #########################币币交易状态码#############################

    /**
     *  币种类型不存在
     */
    CONST CURRENCY_NOT_EXIST = '3009';

    /**
     *  提币数量不能大于可用余额
     */
    CONST WITHDRAW_MONEY_ERROR = '3010';

    /**
     *  提币数量在 xxx - xxx 之间
     */
    CONST WITHDRAW_NUM_RANGE_ERROR = '3011';

    /**
     *  已经撤销
     */
    CONST ALREADY_CNACEL = '3014';



    /**
     *  提币数量已达上限
     */
    CONST WITHDRAW_ALREADY_UP_LIMT = '3017';

    /**
     *  提币地址上限
     */
    CONST WITHDRAW_ADDRESS_UP_LIMIT = '3018';

    /**
     *  提币地址已经存在
     */
    CONST WITHDRAW_ADDRESS_ALREADY_EXISTS = '3019';

    /**
     *  提币地址已经存在
     */
    CONST INTER_ADDRESS = '3020';

    //登录，注册，修改密码，google验证码，二步登录，交易密码等安全类别统一用5000-5999
    /**
     * 注册用户已经存在
     */
    CONST REGISTER_ALREADY = '5000';

    /**
     * 验证码错误或超时
     */
    CONST CAPTCHA = '5001';

    /**
     * 手机号码格式错误
     */
    CONST PHONE_FORMAT_ERROR = '5003';

    /**
     * 不支持的验证码类型
     */
    CONST NOT_SUPPORT_CAPTCHA_TYPE = '5004';

    /**
     * 在规定时间间隔后才能再次发生验证码
     */
    CONST INTERVAL_AGAIN_SEND_CPATCHA = '5005';

    /**
     * 黑名单用户
     */
    CONST BLACKLIST_USER = '5006';

    /**
     * 用户名不存在或密码错误
     */
    CONST PASSWORD_ERROR = '5007';

    /**
     * 已经在线
     */
    CONST ALREADY_ON_LINE = '5008';

    /**
     * 用户未登录
     */
    CONST USER_NOT_LOGIN = '5009';

    /**
     * 登录已过期
     */
    CONST LOGIN_EXPIRE = '5010';

    /**
     * 账号必须为邮箱/手机号码
     */
    CONST ACCOUNT_ERROR = '5011';

    /**
     * 二步登录
     */
    CONST SECOND_CHECK = '5012';

    /**
     * 登录成功
     */
    CONST LOGIN_SUCCESS = '5013';

    /**
     * 二步登录过期
     */
    CONST SECOND_CHECK_EXPIRE = '5014';

    /**
     * 发送成功
     */
    CONST SEND_SUCCESS = '5015';

    /**
     * 发送失败
     */
    CONST SEND_FAILURE = '5016';

    /**
     * 登录密码不能和交易密码一致
     */
    CONST PWD_DIFF = '5017';

    /**
     * 推荐码格式错误
     */
    CONST INVITE_CODE_ERROR = '5018';

    /**
     * 推荐码不存在
     */
    CONST INVITE_CODE_NOT_EXISTS = '5019';

    /**
     * 非法推荐
     */
    CONST ILLEGAL_INVITE = '5020';

    /**
     * 注册成功
     */
    CONST REGISTER_SUCCESS = '5021';

    /**
     * 身份认证信息，重复提交
     */
    CONST REPEAT_SUBMISSION = '5022';

    /**
     * 身份证认证，重复认证
     */
    CONST DUPLICATION_OF_AUTHENTICATION = '5023';

    /**
     * 已绑定的支付方式
     */
    CONST BOUND_PAYMENT_METHOD = '5024';

    /**
     * 新的密码不能与旧的密码相同
     */
    CONST PWD_SIMILARITY = '5025';

    /**
     * 用户不存在
     */
    CONST USER_NOT_EXIST = '5026';

    /**
     * 身份证已经存在
     */
    CONST IDENTITY_EXIST = '5027';

    /**
     * 邮箱已经绑定
     */
    CONST EMAIL_BING = '5028';

    /**
     * 手机号码已经绑定
     */
    CONST PHONE_BING = '5029';

    /**
     * 有一笔资产划转正在审核中
     */
    CONST DUPLICATION_OF_ASSET_TRANSFER = '5032';

    /**
     * 不支持该币种转换
     */
    CONST NOT_SUPPORT_ASSET_TRANSFER = '5033';

    /**
     * 邮箱验证码错误
     */
    CONST CAPTCHA_EMAIL_ERROR = '5034';

    /**
     * 短信验证码错误
     */
    CONST CAPTCHA_MOBILE_ERROR = '5035';

    /**
     * 谷歌验证码错误
     */
    CONST CAPTCHA_GOOGLE_ERROR = '5036';

    /**
     * 对方用户不存在
     */
    CONST RELATICE_USER_NOT_EXIST = '5037';

    /**
     * 对方未实名认证
     */
    CONST RELATICE_NO_CERTIFICATION = '5038';

    /**
     * 密码错误
     */
    CONST LOGIN_PASSWORD_ERROR = '5039';

    /**
     * 交易密码一致
     */
    CONST TRADE_PWD_SAME = '5040';

    /**
     * 新谷歌验证码错误
     */
    CONST NEW_CAPTCHA_GOOGLE_ERROR = '5041';

    /**
     * 旧谷歌验证码错误
     */
    CONST OLD_CAPTCHA_GOOGLE_ERROR = '5042';

    /**
     * 新验证码错误或超时
     */
    CONST NEW_CAPTCHA = '5043';

    /**
     * 旧验证码错误或超时
     */
    CONST OLD_CAPTCHA = '5044';

    /**
     * 账号未注册
     */
    CONST UNREGISTERED = '5045';

    /**
     * 手机号码格式错误
     */
    CONST MOBILE_ERROR = '5046';

    /**
     * 邮箱格式错误
     */
    CONST EMAIL_ERROR = '5047';

    /**
     * 服务器错误
     */
    const FAIL = '0000';

    /**
     * 成功
     */
    const SUCCESS = '200';

    const USER_PERMISSION_ERROR = '405';

}
