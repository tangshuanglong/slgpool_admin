<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 
 * Class UserSecurityType
 *
 * @since 2.0
 *
 * @Entity(table="user_security_type")
 */
class UserSecurityType extends Model
{
    /**
     * 用户禁止访问类型
     * @Id()
     * @Column()
     *
     * @var int
     */
    private $id;

    /**
     * 类型名称，中文
     *
     * @Column(name="type_name_cn", prop="typeNameCn")
     *
     * @var string
     */
    private $typeNameCn;

    /**
     * 类型名称,英文
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
