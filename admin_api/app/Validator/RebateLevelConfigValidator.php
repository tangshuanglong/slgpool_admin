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
 * 邀请返佣等级验证器
 * Class RebateLevelConfigValidator
 * @package App\Validator
 * @Validator(name="RebateLevelConfigValidator")
 */
class RebateLevelConfigValidator
{
    /**
     * @IsInt()
     * @var
     */
    protected $id;

    /**
     * @IsString()
     * @var
     */
    protected $consume_before;

    /**
     * @IsString()
     * @var
     */
    protected $consume_after;

    /**
     * @IsInt()
     * @NotEmpty()
     * @var
     */
    protected $level;

    /**
     * @IsString()
     * @NotEmpty()
     * @var
     */
    protected $unit;

    /**
     * @IsString()
     * @NotEmpty()
     * @var
     */
    protected $coin_type;

    /**
     * @IsString()
     * @NotNull()
     * @var
     */
    protected $rebate_mining;

    /**
     * @IsString()
     * @NotNull()
     * @var
     */
    protected $rebate;
}
