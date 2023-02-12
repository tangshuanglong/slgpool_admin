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
 * 系统验证器
 * Class SystemValidator
 * @package App\Validator
 * @Validator(name="SystemValidator")
 */
class SystemValidator
{
    /**
     * @IsInt()
     * @var
     */
    protected $id;

    /**
     * @IsString()
     * @NotEmpty()
     * @Url()
     * @var
     */
    protected $img_src;

    /**
     * @IsString()
     * @var
     */
    protected $content;

    /**
     * @IsInt()
     * @NotEmpty()
     * @var
     */
    protected $sort_num;

    /**
     * @IsInt()
     * @NotNull()
     * @Enum(values={1,0})
     * @var
     */
    protected $status;

    /**
     * @IsInt()
     * @NotEmpty()
     * @Enum(values={1, 2})
     * @var
     */
    protected $type;

    /**
     * @IsString()
     * @NotEmpty()
     * @Enum(values={"pc", "app"})
     * @var
     */
    protected $use_client;

    /**
     * @IsString()
     * @NotEmpty()
     * @Enum(values={"add", "edit"})
     * @var
     */
    protected $action_type;

    /**
     * @IsString()
     * @var
     */
    protected $link_href;

    /**
     * @IsString()
     * @NotEmpty()
     * @var
     */
    protected $version;

    /**
     * @IsString()
     * @NotEmpty()
     * @var
     */
    protected $url;

    /**
     * @IsInt()
     * @NotNull()
     * @Enum(values={0, 1})
     * @var
     */
    protected $is_force;

    /**
     * @IsString()
     * @var
     */
    protected $remark;
}
