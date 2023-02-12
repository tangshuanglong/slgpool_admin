<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 
 * Class LoanOrder
 *
 * @since 2.0
 *
 * @Entity(table="loan_order")
 */
class LoanOrder extends Model
{
    /**
     * 自动追加质押金，0-否，1-是
     *
     * @Column(name="auto_append_pledge", prop="autoAppendPledge")
     *
     * @var int
     */
    private $autoAppendPledge;

    /**
     * 创建时间
     *
     * @Column(name="create_time", prop="createTime")
     *
     * @var string
     */
    private $createTime;

    /**
     * 日化率
     *
     * @Column(name="daily_rate", prop="dailyRate")
     *
     * @var string
     */
    private $dailyRate;

    /**
     * 强制平仓价格
     *
     * @Column(name="forced_liquidation_price", prop="forcedLiquidationPrice")
     *
     * @var string
     */
    private $forcedLiquidationPrice;

    /**
     * 自增id
     * @Id()
     * @Column()
     *
     * @var int
     */
    private $id;

    /**
     * 利息, 借贷金额*日化率*周期
     *
     * @Column()
     *
     * @var string
     */
    private $interest;

    /**
     * 借贷金额，单位usdt
     *
     * @Column(name="loan_amount", prop="loanAmount")
     *
     * @var string
     */
    private $loanAmount;

    /**
     * 借贷币种id
     *
     * @Column(name="loan_coin_id", prop="loanCoinId")
     *
     * @var int
     */
    private $loanCoinId;

    /**
     * 借贷币种名称
     *
     * @Column(name="loan_coin_name", prop="loanCoinName")
     *
     * @var string
     */
    private $loanCoinName;

    /**
     * 借贷币种价格, usdt/usd的价格
     *
     * @Column(name="loan_coin_price", prop="loanCoinPrice")
     *
     * @var string
     */
    private $loanCoinPrice;

    /**
     * 借贷总价，单位usd
     *
     * @Column(name="loan_total_amount", prop="loanTotalAmount")
     *
     * @var string
     */
    private $loanTotalAmount;

    /**
     * 借贷类型，out-商家贷出，对用户来说就是借款， in-商家借款，对用户来说就是贷出
     *
     * @Column(name="loan_type", prop="loanType")
     *
     * @var string
     */
    private $loanType;

    /**
     * 广告方id
     *
     * @Column(name="merchant_id", prop="merchantId")
     *
     * @var int
     */
    private $merchantId;

    /**
     * 广告方昵称
     *
     * @Column(name="merchant_nick_name", prop="merchantNickName")
     *
     * @var string
     */
    private $merchantNickName;

    /**
     * 广告方uid
     *
     * @Column(name="merchant_uid", prop="merchantUid")
     *
     * @var int
     */
    private $merchantUid;

    /**
     * 拍单方昵称
     *
     * @Column(name="nick_name", prop="nickName")
     *
     * @var string
     */
    private $nickName;

    /**
     * 订单号
     *
     * @Column(name="order_sn", prop="orderSn")
     *
     * @var string
     */
    private $orderSn;

    /**
     * 状态，10-确认信息， 20-进行中，30-质押中，40-已完成， 50-已取消， 60-爆仓
     *
     * @Column(name="order_status", prop="orderStatus")
     *
     * @var int
     */
    private $orderStatus;

    /**
     * 周期
     *
     * @Column()
     *
     * @var string
     */
    private $period;

    /**
     * 质押币种数量
     *
     * @Column(name="pledge_amount", prop="pledgeAmount")
     *
     * @var string
     */
    private $pledgeAmount;

    /**
     * 质押币种id
     *
     * @Column(name="pledge_coin_id", prop="pledgeCoinId")
     *
     * @var int
     */
    private $pledgeCoinId;

    /**
     * 质押币种名称
     *
     * @Column(name="pledge_coin_name", prop="pledgeCoinName")
     *
     * @var string
     */
    private $pledgeCoinName;

    /**
     * 质押币种价格
     *
     * @Column(name="pledge_coin_price", prop="pledgeCoinPrice")
     *
     * @var string
     */
    private $pledgeCoinPrice;

    /**
     * 质押率
     *
     * @Column(name="pledge_rate", prop="pledgeRate")
     *
     * @var string
     */
    private $pledgeRate;

    /**
     * 还款日期
     *
     * @Column(name="repay_date", prop="repayDate")
     *
     * @var int
     */
    private $repayDate;

    /**
     * 拍单用户id
     *
     * @Column()
     *
     * @var int
     */
    private $uid;

    /**
     * 更新时间
     *
     * @Column(name="update_time", prop="updateTime")
     *
     * @var string
     */
    private $updateTime;


    /**
     * @param int $autoAppendPledge
     *
     * @return self
     */
    public function setAutoAppendPledge(int $autoAppendPledge): self
    {
        $this->autoAppendPledge = $autoAppendPledge;

        return $this;
    }

    /**
     * @param string $createTime
     *
     * @return self
     */
    public function setCreateTime(string $createTime): self
    {
        $this->createTime = $createTime;

        return $this;
    }

    /**
     * @param string $dailyRate
     *
     * @return self
     */
    public function setDailyRate(string $dailyRate): self
    {
        $this->dailyRate = $dailyRate;

        return $this;
    }

    /**
     * @param string $forcedLiquidationPrice
     *
     * @return self
     */
    public function setForcedLiquidationPrice(string $forcedLiquidationPrice): self
    {
        $this->forcedLiquidationPrice = $forcedLiquidationPrice;

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
     * @param string $interest
     *
     * @return self
     */
    public function setInterest(string $interest): self
    {
        $this->interest = $interest;

        return $this;
    }

    /**
     * @param string $loanAmount
     *
     * @return self
     */
    public function setLoanAmount(string $loanAmount): self
    {
        $this->loanAmount = $loanAmount;

        return $this;
    }

    /**
     * @param int $loanCoinId
     *
     * @return self
     */
    public function setLoanCoinId(int $loanCoinId): self
    {
        $this->loanCoinId = $loanCoinId;

        return $this;
    }

    /**
     * @param string $loanCoinName
     *
     * @return self
     */
    public function setLoanCoinName(string $loanCoinName): self
    {
        $this->loanCoinName = $loanCoinName;

        return $this;
    }

    /**
     * @param string $loanCoinPrice
     *
     * @return self
     */
    public function setLoanCoinPrice(string $loanCoinPrice): self
    {
        $this->loanCoinPrice = $loanCoinPrice;

        return $this;
    }

    /**
     * @param string $loanTotalAmount
     *
     * @return self
     */
    public function setLoanTotalAmount(string $loanTotalAmount): self
    {
        $this->loanTotalAmount = $loanTotalAmount;

        return $this;
    }

    /**
     * @param string $loanType
     *
     * @return self
     */
    public function setLoanType(string $loanType): self
    {
        $this->loanType = $loanType;

        return $this;
    }

    /**
     * @param int $merchantId
     *
     * @return self
     */
    public function setMerchantId(int $merchantId): self
    {
        $this->merchantId = $merchantId;

        return $this;
    }

    /**
     * @param string $merchantNickName
     *
     * @return self
     */
    public function setMerchantNickName(string $merchantNickName): self
    {
        $this->merchantNickName = $merchantNickName;

        return $this;
    }

    /**
     * @param int $merchantUid
     *
     * @return self
     */
    public function setMerchantUid(int $merchantUid): self
    {
        $this->merchantUid = $merchantUid;

        return $this;
    }

    /**
     * @param string $nickName
     *
     * @return self
     */
    public function setNickName(string $nickName): self
    {
        $this->nickName = $nickName;

        return $this;
    }

    /**
     * @param string $orderSn
     *
     * @return self
     */
    public function setOrderSn(string $orderSn): self
    {
        $this->orderSn = $orderSn;

        return $this;
    }

    /**
     * @param int $orderStatus
     *
     * @return self
     */
    public function setOrderStatus(int $orderStatus): self
    {
        $this->orderStatus = $orderStatus;

        return $this;
    }

    /**
     * @param string $period
     *
     * @return self
     */
    public function setPeriod(string $period): self
    {
        $this->period = $period;

        return $this;
    }

    /**
     * @param string $pledgeAmount
     *
     * @return self
     */
    public function setPledgeAmount(string $pledgeAmount): self
    {
        $this->pledgeAmount = $pledgeAmount;

        return $this;
    }

    /**
     * @param int $pledgeCoinId
     *
     * @return self
     */
    public function setPledgeCoinId(int $pledgeCoinId): self
    {
        $this->pledgeCoinId = $pledgeCoinId;

        return $this;
    }

    /**
     * @param string $pledgeCoinName
     *
     * @return self
     */
    public function setPledgeCoinName(string $pledgeCoinName): self
    {
        $this->pledgeCoinName = $pledgeCoinName;

        return $this;
    }

    /**
     * @param string $pledgeCoinPrice
     *
     * @return self
     */
    public function setPledgeCoinPrice(string $pledgeCoinPrice): self
    {
        $this->pledgeCoinPrice = $pledgeCoinPrice;

        return $this;
    }

    /**
     * @param string $pledgeRate
     *
     * @return self
     */
    public function setPledgeRate(string $pledgeRate): self
    {
        $this->pledgeRate = $pledgeRate;

        return $this;
    }

    /**
     * @param int $repayDate
     *
     * @return self
     */
    public function setRepayDate(int $repayDate): self
    {
        $this->repayDate = $repayDate;

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
     * @param string $updateTime
     *
     * @return self
     */
    public function setUpdateTime(string $updateTime): self
    {
        $this->updateTime = $updateTime;

        return $this;
    }

    /**
     * @return int
     */
    public function getAutoAppendPledge(): ?int
    {
        return $this->autoAppendPledge;
    }

    /**
     * @return string
     */
    public function getCreateTime(): ?string
    {
        return $this->createTime;
    }

    /**
     * @return string
     */
    public function getDailyRate(): ?string
    {
        return $this->dailyRate;
    }

    /**
     * @return string
     */
    public function getForcedLiquidationPrice(): ?string
    {
        return $this->forcedLiquidationPrice;
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
    public function getInterest(): ?string
    {
        return $this->interest;
    }

    /**
     * @return string
     */
    public function getLoanAmount(): ?string
    {
        return $this->loanAmount;
    }

    /**
     * @return int
     */
    public function getLoanCoinId(): ?int
    {
        return $this->loanCoinId;
    }

    /**
     * @return string
     */
    public function getLoanCoinName(): ?string
    {
        return $this->loanCoinName;
    }

    /**
     * @return string
     */
    public function getLoanCoinPrice(): ?string
    {
        return $this->loanCoinPrice;
    }

    /**
     * @return string
     */
    public function getLoanTotalAmount(): ?string
    {
        return $this->loanTotalAmount;
    }

    /**
     * @return string
     */
    public function getLoanType(): ?string
    {
        return $this->loanType;
    }

    /**
     * @return int
     */
    public function getMerchantId(): ?int
    {
        return $this->merchantId;
    }

    /**
     * @return string
     */
    public function getMerchantNickName(): ?string
    {
        return $this->merchantNickName;
    }

    /**
     * @return int
     */
    public function getMerchantUid(): ?int
    {
        return $this->merchantUid;
    }

    /**
     * @return string
     */
    public function getNickName(): ?string
    {
        return $this->nickName;
    }

    /**
     * @return string
     */
    public function getOrderSn(): ?string
    {
        return $this->orderSn;
    }

    /**
     * @return int
     */
    public function getOrderStatus(): ?int
    {
        return $this->orderStatus;
    }

    /**
     * @return string
     */
    public function getPeriod(): ?string
    {
        return $this->period;
    }

    /**
     * @return string
     */
    public function getPledgeAmount(): ?string
    {
        return $this->pledgeAmount;
    }

    /**
     * @return int
     */
    public function getPledgeCoinId(): ?int
    {
        return $this->pledgeCoinId;
    }

    /**
     * @return string
     */
    public function getPledgeCoinName(): ?string
    {
        return $this->pledgeCoinName;
    }

    /**
     * @return string
     */
    public function getPledgeCoinPrice(): ?string
    {
        return $this->pledgeCoinPrice;
    }

    /**
     * @return string
     */
    public function getPledgeRate(): ?string
    {
        return $this->pledgeRate;
    }

    /**
     * @return int
     */
    public function getRepayDate(): ?int
    {
        return $this->repayDate;
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
    public function getUpdateTime(): ?string
    {
        return $this->updateTime;
    }

}
