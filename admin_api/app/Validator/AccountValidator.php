<?php


namespace App\Validator;

use App\Annotation\Mapping\AlphaDash;
use App\Annotation\Mapping\NotNull;
use Swoft\Validator\Annotation\Mapping\Email;
use Swoft\Validator\Annotation\Mapping\IsArray;
use Swoft\Validator\Annotation\Mapping\IsInt;
use Swoft\Validator\Annotation\Mapping\IsString;
use Swoft\Validator\Annotation\Mapping\Length;
use Swoft\Validator\Annotation\Mapping\Max;
use Swoft\Validator\Annotation\Mapping\Min;
use Swoft\Validator\Annotation\Mapping\Mobile;
use Swoft\Validator\Annotation\Mapping\NotEmpty;
use Swoft\Validator\Annotation\Mapping\Url;
use Swoft\Validator\Annotation\Mapping\Validator;
use Swoft\Validator\Annotation\Mapping\Enum;

/**
 * 后台通用验证器
 * Class AccountValidator
 * @package App\Validator
 * @Validator(name="AccountValidator")
 */
class AccountValidator
{
    /**
     * ID
     * @var
     * @IsInt()
     * @NotEmpty()
     */
    protected $id;

    /**
     * 账号
     * @var
     * @IsString()
     * @NotEmpty()
     * @AlphaDash()
     */
    protected $user_name;

    /**
     * 密码
     * @var
     * @IsString()
     * @NotEmpty()
     * @Length(min=6, max=32)
     */
    protected $password;

    /**
     * 角色名称
     * @var
     * @IsArray()
     * @NotEmpty()
     */
    protected $role_ids;

    /**
     * 是否可用状态
     * @var
     * @IsInt()
     * @NotNull()
     * @Enum(values={0,1},message="only 0 or 1")。
     */
    protected $status;


    /**
     * 邮箱
     * @var
     * @IsString()
     * @NotEmpty()
     * @Email()
     */
    protected $email;

    /**
     * @IsString()
     * @NotEmpty()
     * @var
     */
    protected $secret;

    /**
     * 密码
     * @var
     * @IsString()
     * @NotEmpty()
     * @Length(min=6, max=32)
     */
    protected $password_old;

    /**
     * 密码
     * @var
     * @IsString()
     * @NotEmpty()
     * @Length(min=6, max=32)
     */
    protected $password_new;
}
