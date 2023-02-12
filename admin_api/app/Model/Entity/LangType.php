<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 
 * Class LangType
 *
 * @since 2.0
 *
 * @Entity(table="lang_type")
 */
class LangType extends Model
{
    /**
     * 语言类型
     * @Id()
     * @Column()
     *
     * @var int
     */
    private $id;

    /**
     * 状态 1-开启 0-关闭
     *
     * @Column()
     *
     * @var int
     */
    private $status;

    /**
     * 类型码
     *
     * @Column(name="type_code", prop="typeCode")
     *
     * @var string
     */
    private $typeCode;

    /**
     * 语言名
     *
     * @Column(name="type_name", prop="typeName")
     *
     * @var string
     */
    private $typeName;


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
     * @param int $status
     *
     * @return self
     */
    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @param string $typeCode
     *
     * @return self
     */
    public function setTypeCode(string $typeCode): self
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
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getStatus(): ?int
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getTypeCode(): ?string
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

}
