<?php


namespace App\Validator;

use Swoft\Validator\Annotation\Mapping\IsArray;
use Swoft\Validator\Annotation\Mapping\IsInt;
use Swoft\Validator\Annotation\Mapping\Enum;
use Swoft\Validator\Annotation\Mapping\IsString;
use Swoft\Validator\Annotation\Mapping\NotEmpty;
use Swoft\Validator\Annotation\Mapping\Validator;
use App\Annotation\Mapping\NotNull;

/**
 * 配置验证器
 * Class ConfigValidator
 * @package App\Validator
 * @Validator(name="ConfigValidator")
 */
class ConfigValidator
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
    protected $group;

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
    protected $value;

    /**
     * @IsString()
     * @NotEmpty()
     * @var
     */
    protected $start_time;

    /**
     * @IsString()
     * @NotEmpty()
     * @var
     */
    protected $end_time;

    /**
     * @IsInt()
     * @NotNull()
     * @Enum(values={0, 1})
     * @var
     */
    protected $cancel_flag;

    /**
     * @IsString()
     * @NotEmpty()
     * @var
     */
    protected $remark;
}
