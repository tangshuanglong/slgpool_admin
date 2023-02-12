<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 新闻类型表
 * Class NewsType
 *
 * @since 2.0
 *
 * @Entity(table="news_type")
 */
class NewsType extends Model
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
     * 类型代码
     *
     * @Column(name="type_code", prop="typeCode")
     *
     * @var string
     */
    private $typeCode;

    /**
     * 类型名
     *
     * @Column(name="type_name", prop="typeName")
     *
     * @var string
     */
    private $typeName;

    /**
     * 状态：1-可用 0-禁用
     *
     * @Column()
     *
     * @var int
     */
    private $status;

    /**
     * 显示状态:1=显示，2-不显示
     *
     * @Column(name="display_status", prop="displayStatus")
     *
     * @var int|null
     */
    private $displayStatus;

    /**
     * 排序
     *
     * @Column(name="order_num", prop="orderNum")
     *
     * @var int|null
     */
    private $orderNum;


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
     * @param int|null $displayStatus
     *
     * @return self
     */
    public function setDisplayStatus(?int $displayStatus): self
    {
        $this->displayStatus = $displayStatus;

        return $this;
    }

    /**
     * @param int|null $orderNum
     *
     * @return self
     */
    public function setOrderNum(?int $orderNum): self
    {
        $this->orderNum = $orderNum;

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

    /**
     * @return int
     */
    public function getStatus(): ?int
    
    {
        return $this->status;
    }

    /**
     * @return int|null
     */
    public function getDisplayStatus(): ?int
    
    {
        return $this->displayStatus;
    }

    /**
     * @return int|null
     */
    public function getOrderNum(): ?int
    
    {
        return $this->orderNum;
    }


}
