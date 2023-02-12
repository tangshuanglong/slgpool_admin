<?php


namespace App\Validator;

use Swoft\Validator\Annotation\Mapping\IsInt;
use Swoft\Validator\Annotation\Mapping\IsString;
use Swoft\Validator\Annotation\Mapping\NotEmpty;
use Swoft\Validator\Annotation\Mapping\Validator;
use Swoft\Validator\Annotation\Mapping\Enum;

/**
 * 用户验证器
 * Class IdentityLogValidator
 * @package App\Validator
 * @Validator(name="IdentityLogValidator")
 */
class IdentityLogValidator
{
    /**
     * @IsInt()
     * @NotEmpty()
     * @var
     */
    protected $id;

    /**
     * @IsInt()
     * @NotEmpty()
     * @Enum(values={0, 1, 2, 3, 4, 5})
     * @var
     */
    protected $status_flag;

    /**
     * @IsString()
     * @var
     */
    protected $reject_reason;
}
