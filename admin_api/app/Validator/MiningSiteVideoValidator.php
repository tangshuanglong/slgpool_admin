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
 * 矿场视频验证器
 * Class MiningSiteVideoValidator
 * @package App\Validator
 * @Validator(name="MiningSiteVideoValidator")
 */
class MiningSiteVideoValidator
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
    protected $url;

    /**
     * @IsString()
     * @var
     */
    protected $cover_image_url;

    /**
     * @IsInt()
     * @NotNull()
     * @Enum(values={0, 1})
     * @var
     */
    protected $status;

    /**
     * @IsInt()
     * @NotNull()
     * @var
     */
    protected $sort;

}
