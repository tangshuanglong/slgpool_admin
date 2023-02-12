<?php


namespace App\Validator;

use App\Annotation\Mapping\AlphaDash;
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
 * 权限验证器
 * Class AccountValidator
 * @package App\Validator
 * @Validator(name="PermissionValidator")
 */
class PermissionValidator
{
    /**
     * @IsString()
     * @NotEmpty()
     * @Length(max=32)
     * @var
     */
    protected $name_action_cn;

    /**
     * @IsString()
     * @NotEmpty()
     * @Length(max=32)
     * @var
     */
    protected $name_group;

    /**
     * @IsString()
     * @NotEmpty()
     * @Length(max=32)
     * @var
     */
    protected $name_group_cn;

    /**
     * @IsArray()
     * @NotEmpty()
     * @var
     */
    protected $permissions;

    /**
     * @IsString()
     * @NotEmpty()
     * @Length(max=255)
     * @var
     */
    protected $name;

    /**
     * @IsString()
     * @NotEmpty()
     * @Length(max=255)
     * @var
     */
    protected $permission_uri;
}
