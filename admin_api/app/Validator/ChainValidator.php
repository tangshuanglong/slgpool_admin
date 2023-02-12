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
 * 公链验证器
 * Class ChainValidator
 * @package App\Validator
 * @Validator(name="ChainValidator")
 */
class ChainValidator
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
    protected $chain_name;

    /**
     * @IsInt()
     * @var
     */
    protected $confirmation_time;

    /**
     * @IsInt()
     * @var
     */
    protected $next_start_sequence;

    /**
     * @IsString()
     * @NotEmpty()
     * @var
     */
    protected $system_hot_wallet;

    /**
     * @IsString()
     * @NotEmpty()
     * @var
     */
    protected $system_cold_wallet;

    /**
     * @IsInt()
     * @NotNull()
     * @Enum(values={0, 1})
     * @var
     */
    protected $is_graphene;

    /**
     * @IsInt()
     * @NotNull()
     * @Enum(values={0, 1})
     * @var
     */
    protected $is_anonymous;

    /**
     * @IsInt()
     * @NotNull()
     * @Enum(values={0, 1})
     * @var
     */
    protected $cancel_flag;
}
