<?php


namespace App\Validator;

use App\Annotation\Mapping\AlphaDash;
use App\Annotation\Mapping\NotNull;
use Swoft\Validator\Annotation\Mapping\Date;
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
 * 币种验证器
 * Class CoinValidator
 * @package App\Validator
 * @Validator(name="CoinValidator")
 */
class CoinValidator
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
    protected $coin_name_en_complete;

    /**
     * @IsString()
     * @NotEmpty()
     * @var
     */
    protected $coin_name_en;

    /**
     * @IsString()
     * @NotEmpty()
     * @var
     */
    protected $coin_name_cn;

    /**
     * @IsString()
     * @NotEmpty()
     * @var
     */
    protected $total_public_number;

    /**
     * @IsString()
     * @var
     */
    protected $coin_algorithm;

    /**
     * @IsString()
     * @NotEmpty()
     * @var
     */
    protected $official_wallet_link;

    /**
     * @IsString()
     * @var
     */
    protected $official_website_link;

    /**
     * @IsString()
     * @var
     */
    protected $source_code_link;

    /**
     * @IsString()
     * @var
     */
    protected $mining_link;

    /**
     * @IsString()
     * @var
     */
    protected $forum_link;

    /**
     * @IsString()
     * @NotEmpty()
     * @var
     */
    protected $coin_introduction;

    /**
     * @IsString()
     * @NotEmpty()
     * @var
     */
    protected $inventory;

    /**
     * @IsInt()
     * @NotEmpty()
     * @Enum(values={1, 2})
     * @var
     */
    protected $charge_status;

    /**
     * @IsInt()
     * @NotEmpty()
     * @Enum(values={1, 2})
     * @var
     */
    protected $get_cash_status;

    /**
     * @IsInt()
     * @NotNull()
     * @Enum(values={1,0})
     * @var
     */
    protected $show_flag;

    /**
     * @IsString()
     * @NotEmpty()
     * @var
     */
    protected $public_date;

    /**
     * @IsInt()
     * @NotNull()
     * @Enum(values={1,0})
     * @var
     */
    protected $mining_enable;

}
