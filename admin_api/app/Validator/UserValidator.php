<?php


namespace App\Validator;

use App\Annotation\Mapping\AlphaDash;
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
 * 用户验证器
 * Class UserValidator
 * @package App\Validator
 * @Validator(name="UserValidator")
 */
class UserValidator
{
    /**
     * @IsInt()
     * @NotEmpty()
     * @var
     */
    protected $user_id;

    /**
     * @IsInt()
     * @NotEmpty()
     * @var
     */
    protected $invitor_code;

    /**
     * @IsString()
     * @NotEmpty()
     * @var
     */
    protected $coin_name;

    /**
     * @IsString()
     * @NotEmpty()
     * @var
     */
    protected $trade_type;

    /**
     * @IsString()
     * @NotEmpty()
     * @var
     */
    protected $amount;

    /**
     * @IsInt()
     * @NotEmpty()
     * @var
     */
    protected $trade_id;

    /**
     * @IsString()
     * @NotEmpty()
     * @Enum(values={"dw", "mining"})
     * @var
     */
    protected $wallet_type;

    /**
     * @IsInt(name="coin_id")
     * @NotEmpty()
     * @var
     */
    protected $coin_id;

    /**
     * @IsInt()
     * @NotEmpty()
     * @var
     */
    protected $id;

    /**
     * @IsInt()
     * @NotEmpty()
     * @Enum(values={20,30})
     * @var
     */
    protected $status;

    /**
     * @IsString()
     * @Length(max=255)
     * @var
     */
    protected $remark;

}
