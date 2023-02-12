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
 * Class NewsValidator
 * @package App\Validator
 * @Validator(name="NewsValidator")
 */
class NewsValidator
{
    /**
     * @IsInt()
     * @var
     */
    protected $id;

    /**
     * @IsString()
     * @NotEmpty()
     * @var
     */
    protected $title;

    /**
     * @IsString()
     * @var
     */
    protected $content;

    /**
     * @IsString()
     * @NotEmpty()
     * @Enum(values={"article", "news_flash"})
     * @var
     */
    protected $news_type;

    /**
     * @IsString()
     * @NotNull()
     * @var
     */
    protected $type;

    /**
     * @IsInt()
     * @NotNull()
     * @Enum(values={0, 1})
     * @var
     */
    protected $status;

    /**
     * @IsString()
     * @NotNull()
     * @var
     */
    protected $lang_type;

    /**
     * @IsInt()
     * @NotNull()
     * @Enum(values={1, 2})
     * @var
     */
    protected $is_featured;

    /**
     * @IsInt()
     * @NotNull()
     * @var
     */
    protected $order_num;

    /**
     * @IsString()
     * @NotEmpty()
     * @Enum(values={"add", "edit"})
     * @var
     */
    protected $action_type;

}
