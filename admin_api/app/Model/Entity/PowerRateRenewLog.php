<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 电费包记录
 * Class PowerRateRenewLog
 *
 * @since 2.0
 *
 * @Entity(table="power_rate_renew_log")
 */
class PowerRateRenewLog extends Model
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
     * 单位天数 一份多少天
     *
     * @Column()
     *
     * @var int
     */
    private $days;

    /**
     * 自增id
     * @Id()
     * @Column()
     *
     * @var int
     */
    private $id;

    /**
     * 订单id
     *
     * @Column(name="order_id", prop="orderId")
     *
     * @var int
     */
    private $orderId;

    /**
     * 电费 单价
     *
     * @Column(name="power_rate", prop="powerRate")
     *
     * @var string
     */
    private $powerRate;

    /**
     * 电费付费类型， 1-年，2-月
     *
     * @Column(name="power_rate_period", prop="powerRatePeriod")
     *
     * @var int
     */
    private $powerRatePeriod;

    /**
     * 购买数量
     *
     * @Column()
     *
     * @var int
     */
    private $quantity;

    /**
     * 总天数
     *
     * @Column(name="total_days", prop="totalDays")
     *
     * @var int
     */
    private $totalDays;

    /**
     * 总价
     *
     * @Column(name="total_price", prop="totalPrice")
     *
     * @var string
     */
    private $totalPrice;


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
     * @param int $days
     *
     * @return self
     */
    public function setDays(int $days): self
    {
        $this->days = $days;

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
     * @param string $powerRate
     *
     * @return self
     */
    public function setPowerRate(string $powerRate): self
    {
        $this->powerRate = $powerRate;

        return $this;
    }

    /**
     * @param int $powerRatePeriod
     *
     * @return self
     */
    public function setPowerRatePeriod(int $powerRatePeriod): self
    {
        $this->powerRatePeriod = $powerRatePeriod;

        return $this;
    }

    /**
     * @param int $quantity
     *
     * @return self
     */
    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @param int $totalDays
     *
     * @return self
     */
    public function setTotalDays(int $totalDays): self
    {
        $this->totalDays = $totalDays;

        return $this;
    }

    /**
     * @param string $totalPrice
     *
     * @return self
     */
    public function setTotalPrice(string $totalPrice): self
    {
        $this->totalPrice = $totalPrice;

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
     * @return int
     */
    public function getDays(): ?int
    {
        return $this->days;
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
     * @return string
     */
    public function getPowerRate(): ?string
    {
        return $this->powerRate;
    }

    /**
     * @return int
     */
    public function getPowerRatePeriod(): ?int
    {
        return $this->powerRatePeriod;
    }

    /**
     * @return int
     */
    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    /**
     * @return int
     */
    public function getTotalDays(): ?int
    {
        return $this->totalDays;
    }

    /**
     * @return string
     */
    public function getTotalPrice(): ?string
    {
        return $this->totalPrice;
    }

}
