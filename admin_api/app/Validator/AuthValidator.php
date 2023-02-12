<?php

namespace App\Validator;

use App\Annotation\Mapping\AlphaDash;
use Swoft\Validator\Annotation\Mapping\Email;
use Swoft\Validator\Annotation\Mapping\IsInt;
use Swoft\Validator\Annotation\Mapping\IsString;
use Swoft\Validator\Annotation\Mapping\Length;
use Swoft\Validator\Annotation\Mapping\NotEmpty;
use Swoft\Validator\Annotation\Mapping\NotInEnum;
use Swoft\Validator\Annotation\Mapping\Validator;
use Swoft\Validator\Annotation\Mapping\Enum;

/**
 * Class AuthValidator
 * @package App\Validator
 *
 * @Validator(name="AuthValidator")
 */
class AuthValidator{

    /**
     * 账号
     * @IsString()
     * @NotEmpty()
     * @var string
     */
    protected $user_name;

    /**
     * @IsString()
     * @NotEmpty()
     * @Length(min=6,max=32)
     * @var
     */
    protected $password;

    /**
     * @IsString()
     * @NotEmpty()
     * @Length(min=6, max=6)
     * @var
     */
    protected $code;

}
