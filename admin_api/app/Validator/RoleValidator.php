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
 * 角色验证器
 * Class AccountValidator
 * @package App\Validator
 * @Validator(name="RoleValidator")
 */
class RoleValidator
{
    /**
     * @IsInt()
     * @NotEmpty()
     * @var
     */
    protected $id;

    /**
     * @IsString()
     * @NotEmpty()
     * @var
     */
    protected $name_group;

    /**
     * @IsArray()
     * @var
     */
    protected $permission_ids;

    /**
     * @IsString()
     * @NotEmpty()
     * @var
     */
    protected $name;

    /**
     * @IsString()
     * @NotEmpty()
     * @var
     */
    protected $name_cn;

    /**
     * @IsString()
     * @Length(max=64)
     * @var
     */
    protected $description;

    /**
     * @IsInt()
     * @var
     */
    protected $pid;

}
