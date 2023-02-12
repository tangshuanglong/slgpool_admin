<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 
 * Class WalletPayOrders
 *
 * @since 2.0
 *
 * @Entity(table="wallet_pay_orders")
 */
class WalletPayOrders extends Model
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
     * 付款类型
     *
     * @Column(name="method_id", prop="methodId")
     *
     * @var int
     */
    private $methodId;

    /**
     * 订单ID
     *
     * @Column(name="order_id", prop="orderId")
     *
     * @var string
     */
    private $orderId;

    /**
     * 用户ID
     *
     * @Column()
     *
     * @var int
     */
    private $uid;

    /**
     * 用户付款银行外部订单号
     *
     * @Column(name="out_trade_order_no", prop="outTradeOrderNo")
     *
     * @var string
     */
    private $outTradeOrderNo;

    /**
     * 订单状态
     *
     * @Column()
     *
     * @var int
     */
    private $status;

    /**
     * 付款人姓名
     *
     * @Column(name="account_name", prop="accountName")
     *
     * @var string
     */
    private $accountName;

    /**
     * 付款卡号
     *
     * @Column(name="account_number", prop="accountNumber")
     *
     * @var string
     */
    private $accountNumber;

    /**
     * 付款额度
     *
     * @Column()
     *
     * @var float
     */
    private $price;

    /**
     * 
     *
     * @Column(name="create_time", prop="createTime")
     *
     * @var int|null
     */
    private $createTime;

    /**
     * 
     *
     * @Column(name="update_time", prop="updateTime")
     *
     * @var int|null
     */
    private $updateTime;

    /**
     * 审核人
     *
     * @Column(name="reviewer_by", prop="reviewerBy")
     *
     * @var string|null
     */
    private $reviewerBy;

    /**
     * 审核时间
     *
     * @Column(name="review_time", prop="reviewTime")
     *
     * @var string|null
     */
    private $reviewTime;

    /**
     * 
     *
     * @Column(name="actual_price", prop="actualPrice")
     *
     * @var float|null
     */
    private $actualPrice;


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
     * @param int $methodId
     *
     * @return self
     */
    public function setMethodId(int $methodId): self
    {
        $this->methodId = $methodId;

        return $this;
    }

    /**
     * @param string $orderId
     *
     * @return self
     */
    public function setOrderId(string $orderId): self
    {
        $this->orderId = $orderId;

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
     * @param string $outTradeOrderNo
     *
     * @return self
     */
    public function setOutTradeOrderNo(string $outTradeOrderNo): self
    {
        $this->outTradeOrderNo = $outTradeOrderNo;

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
     * @param string $accountName
     *
     * @return self
     */
    public function setAccountName(string $accountName): self
    {
        $this->accountName = $accountName;

        return $this;
    }

    /**
     * @param string $accountNumber
     *
     * @return self
     */
    public function setAccountNumber(string $accountNumber): self
    {
        $this->accountNumber = $accountNumber;

        return $this;
    }

    /**
     * @param float $price
     *
     * @return self
     */
    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @param int|null $createTime
     *
     * @return self
     */
    public function setCreateTime(?int $createTime): self
    {
        $this->createTime = $createTime;

        return $this;
    }

    /**
     * @param int|null $updateTime
     *
     * @return self
     */
    public function setUpdateTime(?int $updateTime): self
    {
        $this->updateTime = $updateTime;

        return $this;
    }

    /**
     * @param string|null $reviewerBy
     *
     * @return self
     */
    public function setReviewerBy(?string $reviewerBy): self
    {
        $this->reviewerBy = $reviewerBy;

        return $this;
    }

    /**
     * @param string|null $reviewTime
     *
     * @return self
     */
    public function setReviewTime(?string $reviewTime): self
    {
        $this->reviewTime = $reviewTime;

        return $this;
    }

    /**
     * @param float|null $actualPrice
     *
     * @return self
     */
    public function setActualPrice(?float $actualPrice): self
    {
        $this->actualPrice = $actualPrice;

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
    public function getMethodId(): ?int
    {
        return $this->methodId;
    }

    /**
     * @return string
     */
    public function getOrderId(): ?string
    {
        return $this->orderId;
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
    public function getOutTradeOrderNo(): ?string
    {
        return $this->outTradeOrderNo;
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
    public function getAccountName(): ?string
    {
        return $this->accountName;
    }

    /**
     * @return string
     */
    public function getAccountNumber(): ?string
    {
        return $this->accountNumber;
    }

    /**
     * @return float
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * @return int|null
     */
    public function getCreateTime(): ?int
    {
        return $this->createTime;
    }

    /**
     * @return int|null
     */
    public function getUpdateTime(): ?int
    {
        return $this->updateTime;
    }

    /**
     * @return string|null
     */
    public function getReviewerBy(): ?string
    {
        return $this->reviewerBy;
    }

    /**
     * @return string|null
     */
    public function getReviewTime(): ?string
    {
        return $this->reviewTime;
    }

    /**
     * @return float|null
     */
    public function getActualPrice(): ?float
    {
        return $this->actualPrice;
    }

}
