<?php


namespace App\Validator;

use App\Annotation\Mapping\NotNull;
use Swoft\Validator\Annotation\Mapping\IsArray;
use Swoft\Validator\Annotation\Mapping\IsInt;
use Swoft\Validator\Annotation\Mapping\IsString;
use Swoft\Validator\Annotation\Mapping\NotEmpty;
use Swoft\Validator\Annotation\Mapping\Validator;

/**
 * 产品活动验证器
 * Class MiningProductActivityValidator
 * @package App\Validator
 * @Validator(name="MiningProductActivityValidator")
 */
class MiningProductActivityValidator
{
    /**
     * @IsInt()
     * @var
     */
    protected $id;

    /**
     * @IsInt()
     * @NotNull()
     * @var
     */
    protected $product_id;

    /**
     * @IsInt()
     * @NotNull()
     * @var
     */
    protected $after_quantity;

    /**
     * @IsInt()
     * @NotNull()
     * @var
     */
    protected $before_quantity;

    /**
     * @IsString()
     * @NotNull()
     * @var
     */
    protected $reward_ratio;

    /**
     * @IsInt()
     * @NotNull()
     * @var
     */
    protected $status_flag;
}
