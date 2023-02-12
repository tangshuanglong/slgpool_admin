<?php


namespace App\Validator;

use App\Annotation\Mapping\NotNull;
use Swoft\Validator\Annotation\Mapping\Enum;
use Swoft\Validator\Annotation\Mapping\IsArray;
use Swoft\Validator\Annotation\Mapping\IsInt;
use Swoft\Validator\Annotation\Mapping\IsString;
use Swoft\Validator\Annotation\Mapping\Max;
use Swoft\Validator\Annotation\Mapping\Min;
use Swoft\Validator\Annotation\Mapping\NotEmpty;
use Swoft\Validator\Annotation\Mapping\Validator;

/**
 * 产品验证器
 * Class ProductValidator
 * @package App\Validator
 * @Validator(name="ProductValidator")
 */
class ProductValidator
{
    /**
     * @IsInt()
     * @var
     */
    protected $id;

    /**
     * @IsInt()
     * @NotEmpty()
     * @var
     */
    protected $mining_machine_id;

    /**
     * @IsString()
     * @var
     */
    protected $coin_type;

    /**
     * @IsInt()
     * @Enum(values={1, 2, 3})
     * @NotNull()
     * @var
     */
    protected $product_type;

    /**
     * @IsString()
     * @NotEmpty()
     * @var
     */
    protected $product_name;

    /**
     * @IsInt()
     * @Min(value=0,message="总数量必须为正整数")
     * @NotEmpty()
     * @var
     */
    protected $total_quantity;

    /**
     * @IsInt()
     * @Min(value=0,message="剩余数量必须为正整数")
     * @NotEmpty()
     * @var
     */
    protected $last_quantity;

    /**
     * @IsString()
     * @NotEmpty()
     * @var
     */
    protected $product_hash;

    /**
     * @IsString()
     * @var
     */
    protected $real_hash;

    /**
     * @IsString()
     * @NotEmpty()
     * @var
     */
    protected $price;

    /**
     * @IsInt()
     * @Min(value=0,message="周期必须为正整数")
     * @NotEmpty()
     * @var
     */
    protected $period;

    /**
     * @IsString()
     * @var
     */
    protected $manage_fee;

    /**
     * @IsString()
     * @NotNull()
     * @var
     */
    protected $added_time;

    /**
     * @IsInt()
     * @Enum(values={1, 2})
     * @var
     */
    protected $property;

    /**
     * @IsString()
     * @var
     */
    protected $detail;

    /**
     * @IsString()
     * @var
     */
    protected $feature;

    /**
     * @IsInt()
     * @Min(value=0,message="限购数必须为正整数")
     * @var
     */
    protected $limited;

    /**
     * @IsInt()
     * @Enum(values={0, 1})
     * @NotNull()
     * @var
     */
    protected $is_sell;

    /**
     * @IsInt()
     * @Enum(values={0, 1})
     * @NotNull()
     * @var
     */
    protected $is_limit_time;

    /**
     * @IsInt()
     * @Enum(values={0, 1})
     * @NotNull()
     * @var
     */
    protected $is_limited;

    /**
     * @IsInt()
     * @Enum(values={0, 1})
     * @NotNull()
     * @var
     */
    protected $is_activity;

    /**
     * @IsInt()
     * @Enum(values={0, 1})
     * @NotNull()
     * @var
     */
    protected $is_resell;

    /**
     * @IsInt()
     * @Enum(values={0, 1})
     * @NotNull()
     * @var
     */
    protected $is_recommend;

    /**
     * @IsInt()
     * @Enum(values={0, 1})
     * @NotNull()
     * @var
     */
    protected $is_experience;

    /**
     * @IsInt()
     * @Enum(values={0, 1})
     * @NotNull()
     * @var
     */
    protected $status_flag;

    /**
     * @IsInt()
     * @Min(value=0,message="抵押金额必须为正整数")
     * @NotNull()
     * @var
     */
    protected $pledge;

    /**
     * @IsInt()
     * @Enum(values={0, 1})
     * @NotNull()
     * @var
     */
    protected $is_pledge;

    /**
     * @IsString()
     * @NotNull()
     * @var
     */
    protected $product_init_work_day;

    /**
     * @IsString()
     * @NotNull()
     * @var
     */
    protected $work_number;

    /**
     * @IsString()
     * @var
     */
    protected $product_tag_ids;

    /**
     * @IsString()
     * @var
     */
    protected $start_time;

    /**
     * @IsString()
     * @var
     */
    protected $end_time;
}
