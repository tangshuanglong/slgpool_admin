<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 产品标签表
 * Class ProductTag
 *
 * @since 2.0
 *
 * @Entity(table="product_tag")
 */
class ProductTag extends Model
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
     * 标签名
     *
     * @Column()
     *
     * @var string|null
     */
    private $name;

    /**
     * 排序
     *
     * @Column(name="order_num", prop="orderNum")
     *
     * @var int|null
     */
    private $orderNum;

    /**
     * 标签路径
     *
     * @Column()
     *
     * @var string|null
     */
    private $url;


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
     * @param string|null $name
     *
     * @return self
     */
    public function setName(?string $name): self
    {
        $this->name = $name;

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
     * @param string|null $url
     *
     * @return self
     */
    public function setUrl(?string $url): self
    {
        $this->url = $url;

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
     * @return string|null
     */
    public function getName(): ?string
    
    {
        return $this->name;
    }

    /**
     * @return int|null
     */
    public function getOrderNum(): ?int
    
    {
        return $this->orderNum;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    
    {
        return $this->url;
    }


}
