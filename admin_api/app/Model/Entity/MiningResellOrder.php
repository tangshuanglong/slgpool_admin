<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 
 * Class MiningResellOrder
 *
 * @since 2.0
 *
 * @Entity(table="mining_resell_order")
 */
class MiningResellOrder extends Model
{
    /**
     * 创建时间
     *
     * @Column(name="created_at", prop="createdAt")
     *
     * @var string
     */
    private $createdAt;

    /**
     * 折扣
     *
     * @Column()
     *
     * @var string
     */
    private $discount;

    /**
     * 自增ID
     * @Id()
     * @Column()
     *
     * @var int
     */
    private $id;

    /**
     * 订单ID
     *
     * @Column(name="order_id", prop="orderId")
     *
     * @var int
     */
    private $orderId;

    /**
     * 接手的订单id
     *
     * @Column(name="to_order_id", prop="toOrderId")
     *
     * @var int
     */
    private $toOrderId;

    /**
     * 接手的用户id
     *
     * @Column(name="to_uid", prop="toUid")
     *
     * @var int
     */
    private $toUid;

    /**
     * 转让的用户id
     *
     * @Column()
     *
     * @var int
     */
    private $uid;

    /**
     * 更新时间
     *
     * @Column(name="updated_at", prop="updatedAt")
     *
     * @var string
     */
    private $updatedAt;


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
     * @param string $discount
     *
     * @return self
     */
    public function setDiscount(string $discount): self
    {
        $this->discount = $discount;

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
     * @param int $orderId
     *
     * @return self
     */
    public function setOrderId(int $orderId): self
    {
        $this->orderId = $orderId;

        return $this;
    }

    /**
     * @param int $toOrderId
     *
     * @return self
     */
    public function setToOrderId(int $toOrderId): self
    {
        $this->toOrderId = $toOrderId;

        return $this;
    }

    /**
     * @param int $toUid
     *
     * @return self
     */
    public function setToUid(int $toUid): self
    {
        $this->toUid = $toUid;

        return $this;
    }

    /**
     * @param int $uid
     *
     * @return self
     */
    public function setUid(int $uid): self
    {
        $this->uid = $uid;

        return $this;
    }

    /**
     * @param string $updatedAt
     *
     * @return self
     */
    public function setUpdatedAt(string $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

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
     * @return string
     */
    public function getDiscount(): ?string
    {
        return $this->discount;
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
    public function getOrderId(): ?int
    {
        return $this->orderId;
    }

    /**
     * @return int
     */
    public function getToOrderId(): ?int
    {
        return $this->toOrderId;
    }

    /**
     * @return int
     */
    public function getToUid(): ?int
    {
        return $this->toUid;
    }

    /**
     * @return int
     */
    public function getUid(): ?int
    {
        return $this->uid;
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

}
