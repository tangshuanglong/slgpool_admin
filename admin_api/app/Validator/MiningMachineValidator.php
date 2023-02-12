<?php


namespace App\Validator;

use Swoft\Validator\Annotation\Mapping\IsArray;
use Swoft\Validator\Annotation\Mapping\IsInt;
use Swoft\Validator\Annotation\Mapping\IsString;
use Swoft\Validator\Annotation\Mapping\NotEmpty;
use Swoft\Validator\Annotation\Mapping\Validator;

/**
 * 矿机验证器
 * Class MiningMachineValidator
 * @package App\Validator
 * @Validator(name="MiningMachineValidator")
 */
class MiningMachineValidator
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
    protected $name;

    /**
     * @IsInt()
     * @var
     */
    protected $power;

    /**
     * @IsArray()
     * @NotEmpty()
     * @var
     */
    protected $images;

    /**
     * @IsString()
     * @NotEmpty()
     * @var
     */
    protected $hash_rate;

    /**
     * @IsString()
     * @NotEmpty()
     * @var
     */
    protected $voltage;

    /**
     * @IsInt()
     * @NotEmpty()
     * @var
     */
    protected $weight;

    /**
     * @IsString()
     * @NotEmpty()
     * @var
     */
    protected $size;

    /**
     * @IsString()
     * @NotEmpty()
     * @var
     */
    protected $worker_temp;

    /**
     * @IsString()
     * @NotEmpty()
     * @var
     */
    protected $worker_hum;

    /**
     * @IsInt()
     * @NotEmpty()
     * @var
     */
    protected $noise;

    /**
     * @IsString()
     * @NotEmpty()
     * @var
     */
    protected $algorithm;

    /**
     * @IsString()
     * @var
     */
    protected $description;
}
