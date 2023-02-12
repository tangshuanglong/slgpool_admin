<?php


namespace App\Validator;

use Swoft\Validator\Annotation\Mapping\IsArray;
use Swoft\Validator\Annotation\Mapping\IsInt;
use Swoft\Validator\Annotation\Mapping\IsString;
use Swoft\Validator\Annotation\Mapping\NotEmpty;
use Swoft\Validator\Annotation\Mapping\Validator;
use App\Annotation\Mapping\NotNull;
use Swoft\Validator\Annotation\Mapping\Enum;

/**
 * 币种Token验证器
 * Class CoinTokenValidator
 * @package App\Validator
 * @Validator(name="CoinTokenValidator")
 */
class CoinTokenValidator
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
    protected $coinId;

    /**
     * @IsString()
     * @var
     */
    protected $coin_name;

    /**
     * @IsInt()
     * @NotEmpty()
     * @var
     */
    protected $chain_id;

    /**
     * @IsString()
     * @NotEmpty()
     * @var
     */
    protected $display_name;

    /**
     * @IsString()
     * @NotEmpty()
     * @var
     */
    protected $contract_address;

    /**
     * @IsString()
     * @var
     */
    protected $contract_abi;

    /**
     * @IsInt()
     * @NotEmpty()
     * @var
     */
    protected $decimals;

    /**
     * @IsString()
     * @NotEmpty()
     * @var
     */
    protected $account_name;

    /**
     * @IsInt()
     * @NotNull()
     * @Enum(values={0, 1})
     * @var
     */
    protected $is_main;

    /**
     * @IsInt()
     * @NotEmpty()
     * @var
     */
    protected $property_id;

    /**
     * @IsString()
     * @NotEmpty()
     * @var
     */
    protected $explorer_url;

    /**
     * @IsString()
     * @NotEmpty()
     * @var
     */
    protected $explorer_url_parameter_address;

    /**
     * @IsString()
     * @NotEmpty()
     * @var
     */
    protected $explorer_url_parameter_tx;

    /**
     * @IsString()
     * @NotEmpty()
     * @var
     */
    protected $withdraw_theshold;

    /**
     * @IsString()
     * @NotEmpty()
     * @var
     */
    protected $warning_amount;

    /**
     * @IsString()
     * @NotEmpty()
     * @var
     */
    protected $withdraw_fee;

    /**
     * @IsString()
     * @NotEmpty()
     * @var
     */
    protected $min_withdraw;

    /**
     * @IsString()
     * @NotEmpty()
     * @var
     */
    protected $max_withdraw;

    /**
     * @IsString()
     * @NotEmpty()
     * @var
     */
    protected $min_deposit;

    /**
     * @IsInt()
     * @NotNull()
     * @Enum(values={0, 1})
     * @var
     */
    protected $cancel_flag;
}
