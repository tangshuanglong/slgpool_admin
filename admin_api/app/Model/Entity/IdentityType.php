<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 
 * Class IdentityType
 *
 * @since 2.0
 *
 * @Entity(table="identity_type")
 */
class IdentityType extends Model
{
    /**
     * 证件类型表
     * @Id()
     * @Column()
     *
     * @var int
     */
    private $id;

    /**
     * 证件类型编码，可选
     *
     * @Column(name="type_code", prop="typeCode")
     *
     * @var int|null
     */
    private $typeCode;

    /**
     * 证件类型名称
     *
     * @Column(name="type_name", prop="typeName")
     *
     * @var string
     */
    private $typeName;

    /**
     * 证件类型名称，英文
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
     * @param int|null $typeCode
     *
     * @return self
     */
    public function setTypeCode(?int $typeCode): self
    {
        $this->typeCode = $typeCode;

        return $this;
    }

    /**
     * @param string $typeName
     *
     * @return self
     */
    public function setTypeName(string $typeName): self
    {
        $this->typeName = $typeName;

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
     * @return int|null
     */
    public function getTypeCode(): ?int
    {
        return $this->typeCode;
    }

    /**
     * @return string
     */
    public function getTypeName(): ?string
    {
        return $this->typeName;
    }

    /**
     * @return string
     */
    public function getTypeNameEn(): ?string
    {
        return $this->typeNameEn;
    }

}
