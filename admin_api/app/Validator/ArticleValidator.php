<?php


namespace App\Validator;

use App\Annotation\Mapping\NotNull;
use Swoft\Validator\Annotation\Mapping\Enum;
use Swoft\Validator\Annotation\Mapping\IsArray;
use Swoft\Validator\Annotation\Mapping\IsInt;
use Swoft\Validator\Annotation\Mapping\IsString;
use Swoft\Validator\Annotation\Mapping\NotEmpty;
use Swoft\Validator\Annotation\Mapping\Validator;

/**
 * 文章验证器
 * Class ArticleValidator
 * @package App\Validator
 * @Validator(name="ArticleValidator")
 */
class ArticleValidator
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
    protected $thumbnail;

    /**
     * @IsString()
     * @var
     */
    protected $content;

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
    protected $type;

    /**
     * @IsInt()
     * @NotNull()
     * @Enum(values={0, 1})
     * @var
     */
    protected $is_pushed;

    /**
     * @IsInt()
     * @NotNull()
     * @var
     */
    protected $order_num;

    /**
     * @IsString()
     * @NotNull()
     * @var
     */
    protected $lang_type;

}
