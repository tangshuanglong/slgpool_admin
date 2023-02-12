<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 参数说明表
 * Class MiningExplain
 *
 * @since 2.0
 *
 * @Entity(table="mining_explain")
 */
class MiningExplain extends Model
{
    /**
     * 挖矿页面参数说明
     *
     * @Column(name="created_at", prop="createdAt")
     *
     * @var string
     */
    private $createdAt;

    /**
     * 字段说明
     *
     * @Column(name="field_explain", prop="fieldExplain")
     *
     * @var string|null
     */
    private $fieldExplain;

    /**
     * 字段名称
     *
     * @Column(name="field_name", prop="fieldName")
     *
     * @var string
     */
    private $fieldName;

    /**
     * 自增ID
     * @Id()
     * @Column()
     *
     * @var int
     */
    private $id;


    /**
     * @param string $createdAt
     *
     * @return self
     */
    public function setCreatedAt(string $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @param string|null $fieldExplain
     *
     * @return self
     */
    public function setFieldExplain(?string $fieldExplain): self
    {
        $this->fieldExplain = $fieldExplain;

        return $this;
    }

    /**
     * @param string $fieldName
     *
     * @return self
     */
    public function setFieldName(string $fieldName): self
    {
        $this->fieldName = $fieldName;

        return $this;
    }

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
     * @return string
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * @return string|null
     */
    public function getFieldExplain(): ?string
    {
        return $this->fieldExplain;
    }

    /**
     * @return string
     */
    public function getFieldName(): ?string
    {
        return $this->fieldName;
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

}
