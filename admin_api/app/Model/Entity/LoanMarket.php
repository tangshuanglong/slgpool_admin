<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 
 * Class LoanMarket
 *
 * @since 2.0
 *
 * @Entity(table="loan_market")
 */
class LoanMarket extends Model
{
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
     * 自增id
     * @Id()
     * @Column()
     *
     * @var int
     */
    private $id;

    /**
     * 保持率，价格幅度维持金额
     *
     * @Column(name="keep_rate", prop="keepRate")
     *
     * @var string
     */
    private $keepRate;

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
     * 借贷类型，out-商家贷出，对用户来说就是借款， in-商家借款，对用户来说就是贷出
     *
     * @Column(name="loan_type", prop="loanType")
     *
     * @var string
     */
    private $loanType;

    /**
     * 最大交易金额
     *
     * @Column(name="max_trade_limit", prop="maxTradeLimit")
     *
     * @var int
     */
    private $maxTradeLimit;

    /**
     * 商人id
     *
     * @Column(name="merchant_id", prop="merchantId")
     *
     * @var int
     */
    private $merchantId;

    /**
     * 商人名称
     *
     * @Column(name="merchant_name", prop="merchantName")
     *
     * @var string
     */
    private $merchantName;

    /**
     * 最小交易金额
     *
     * @Column(name="min_trade_limit", prop="minTradeLimit")
     *
     * @var int
     */
    private $minTradeLimit;

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
     * 币种价格
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
     * 状态，0-下架，1-上架
     *
     * @Column()
     *
     * @var int
     */
    private $status;

    /**
     * 用户id
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
     * @param string $keepRate
     *
     * @return self
     */
    public function setKeepRate(string $keepRate): self
    {
        $this->keepRate = $keepRate;

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
     * @param int $maxTradeLimit
     *
     * @return self
     */
    public function setMaxTradeLimit(int $maxTradeLimit): self
    {
        $this->maxTradeLimit = $maxTradeLimit;

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
     * @param string $merchantName
     *
     * @return self
     */
    public function setMerchantName(string $merchantName): self
    {
        $this->merchantName = $merchantName;

        return $this;
    }

    /**
     * @param int $minTradeLimit
     *
     * @return self
     */
    public function setMinTradeLimit(int $minTradeLimit): self
    {
        $this->minTradeLimit = $minTradeLimit;

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
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getKeepRate(): ?string
    {
        return $this->keepRate;
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
    public function getLoanType(): ?string
    {
        return $this->loanType;
    }

    /**
     * @return int
     */
    public function getMaxTradeLimit(): ?int
    {
        return $this->maxTradeLimit;
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
    public function getMerchantName(): ?string
    {
        return $this->merchantName;
    }

    /**
     * @return int
     */
    public function getMinTradeLimit(): ?int
    {
        return $this->minTradeLimit;
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
    public function getStatus(): ?int
    {
        return $this->status;
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
