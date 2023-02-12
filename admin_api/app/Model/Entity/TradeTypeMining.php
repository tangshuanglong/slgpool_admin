<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 交易类型表
 * Class TradeTypeMining
 *
 * @since 2.0
 *
 * @Entity(table="trade_type_mining")
 */
class TradeTypeMining extends Model
{
    /**
     * 
     * @Id()
     * @Column()
     *
     * @var int
     */
    private $id;

    /**
     * 显示类型，0-对内，1-对外，用户可以看到的
     *
     * @Column(name="show_type", prop="showType")
     *
     * @var int
     */
    private $showType;

    /**
     * 交易类型名（中文）
     *
     * @Column(name="type_name_cn", prop="typeNameCn")
     *
     * @var string
     */
    private $typeNameCn;

    /**
     * 交易类型名（英文）
     *
     * @Column(name="type_name_en", prop="typeNameEn")
     *
     * @var string
     */
    private $typeNameEn;


    /**
     * @param int $id
     *
     * @return self
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param int $showType
     *
     * @return self
     */
    public function setShowType(int $showType): self
    {
        $this->showType = $showType;

        return $this;
    }

    /**
     * @param string $typeNameCn
     *
     * @return self
     */
    public function setTypeNameCn(string $typeNameCn): self
    {
        $this->typeNameCn = $typeNameCn;

        return $this;
    }

    /**
     * @param string $typeNameEn
     *
     * @return self
     */
    public function setTypeNameEn(string $typeNameEn): self
    {
        $this->typeNameEn = $typeNameEn;

        return $this;
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getShowType(): ?int
    {
        return $this->showType;
    }

    /**
     * @return string
     */
    public function getTypeNameCn(): ?string
    {
        return $this->typeNameCn;
    }

    /**
     * @return string
     */
    public function getTypeNameEn(): ?string
    {
        return $this->typeNameEn;
    }

}
