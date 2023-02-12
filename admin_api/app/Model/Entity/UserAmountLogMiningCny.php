<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 
 * Class UserAmountLogMiningCny
 *
 * @since 2.0
 *
 * @Entity(table="user_amount_log_mining_cny")
 */
class UserAmountLogMiningCny extends Model
{
    /**
     * 用户该币种在交易前的可用余额
     *
     * @Column(name="after_free_amount", prop="afterFreeAmount")
     *
     * @var string
     */
    private $afterFreeAmount;

    /**
     * 用户该币种在交易前的冻结余额
     *
     * @Column(name="after_frozen_amount", prop="afterFrozenAmount")
     *
     * @var string
     */
    private $afterFrozenAmount;

    /**
     * 用户该币种在交易前的抵押余额
     *
     * @Column(name="after_pledge_amount", prop="afterPledgeAmount")
     *
     * @var string
     */
    private $afterPledgeAmount;

    /**
     * 用户该币种在交易后的可用余额
     *
     * @Column(name="before_free_amount", prop="beforeFreeAmount")
     *
     * @var string
     */
    private $beforeFreeAmount;

    /**
     * 用户该币种在交易后的冻结余额
     *
     * @Column(name="before_frozen_amount", prop="beforeFrozenAmount")
     *
     * @var string
     */
    private $beforeFrozenAmount;

    /**
     * 用户该币种在交易后的抵押余额
     *
     * @Column(name="before_pledge_amount", prop="beforePledgeAmount")
     *
     * @var string
     */
    private $beforePledgeAmount;

    /**
     * 创建记录的时间
     *
     * @Column(name="create_time", prop="createTime")
     *
     * @var string
     */
    private $createTime;

    /**
     * 挖矿余额记录表
     * @Id()
     * @Column()
     *
     * @var int
     */
    private $id;

    /**
     * 交易币的数量
     *
     * @Column(name="trade_coin_amount", prop="tradeCoinAmount")
     *
     * @var string
     */
    private $tradeCoinAmount;

    /**
     * 交易币种id
     *
     * @Column(name="trade_coin_id", prop="tradeCoinId")
     *
     * @var int
     */
    private $tradeCoinId;

    /**
     * 交易货币类型
     *
     * @Column(name="trade_coin_type", prop="tradeCoinType")
     *
     * @var string
     */
    private $tradeCoinType;

    /**
     * 交易类型id
     *
     * @Column(name="trade_type_id", prop="tradeTypeId")
     *
     * @var int
     */
    private $tradeTypeId;

    /**
     * 
     *
     * @Column()
     *
     * @var int
     */
    private $uid;


    /**
     * @param string $afterFreeAmount
     *
     * @return self
     */
    public function setAfterFreeAmount(string $afterFreeAmount): self
    {
        $this->afterFreeAmount = $afterFreeAmount;

        return $this;
    }

    /**
     * @param string $afterFrozenAmount
     *
     * @return self
     */
    public function setAfterFrozenAmount(string $afterFrozenAmount): self
    {
        $this->afterFrozenAmount = $afterFrozenAmount;

        return $this;
    }

    /**
     * @param string $afterPledgeAmount
     *
     * @return self
     */
    public function setAfterPledgeAmount(string $afterPledgeAmount): self
    {
        $this->afterPledgeAmount = $afterPledgeAmount;

        return $this;
    }

    /**
     * @param string $beforeFreeAmount
     *
     * @return self
     */
    public function setBeforeFreeAmount(string $beforeFreeAmount): self
    {
        $this->beforeFreeAmount = $beforeFreeAmount;

        return $this;
    }

    /**
     * @param string $beforeFrozenAmount
     *
     * @return self
     */
    public function setBeforeFrozenAmount(string $beforeFrozenAmount): self
    {
        $this->beforeFrozenAmount = $beforeFrozenAmount;

        return $this;
    }

    /**
     * @param string $beforePledgeAmount
     *
     * @return self
     */
    public function setBeforePledgeAmount(string $beforePledgeAmount): self
    {
        $this->beforePledgeAmount = $beforePledgeAmount;

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
     * @param string $tradeCoinAmount
     *
     * @return self
     */
    public function setTradeCoinAmount(string $tradeCoinAmount): self
    {
        $this->tradeCoinAmount = $tradeCoinAmount;

        return $this;
    }

    /**
     * @param int $tradeCoinId
     *
     * @return self
     */
    public function setTradeCoinId(int $tradeCoinId): self
    {
        $this->tradeCoinId = $tradeCoinId;

        return $this;
    }

    /**
     * @param string $tradeCoinType
     *
     * @return self
     */
    public function setTradeCoinType(string $tradeCoinType): self
    {
        $this->tradeCoinType = $tradeCoinType;

        return $this;
    }

    /**
     * @param int $tradeTypeId
     *
     * @return self
     */
    public function setTradeTypeId(int $tradeTypeId): self
    {
        $this->tradeTypeId = $tradeTypeId;

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
     * @return string
     */
    public function getAfterFreeAmount(): ?string
    {
        return $this->afterFreeAmount;
    }

    /**
     * @return string
     */
    public function getAfterFrozenAmount(): ?string
    {
        return $this->afterFrozenAmount;
    }

    /**
     * @return string
     */
    public function getAfterPledgeAmount(): ?string
    {
        return $this->afterPledgeAmount;
    }

    /**
     * @return string
     */
    public function getBeforeFreeAmount(): ?string
    {
        return $this->beforeFreeAmount;
    }

    /**
     * @return string
     */
    public function getBeforeFrozenAmount(): ?string
    {
        return $this->beforeFrozenAmount;
    }

    /**
     * @return string
     */
    public function getBeforePledgeAmount(): ?string
    {
        return $this->beforePledgeAmount;
    }

    /**
     * @return string
     */
    public function getCreateTime(): ?string
    {
        return $this->createTime;
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
    public function getTradeCoinAmount(): ?string
    {
        return $this->tradeCoinAmount;
    }

    /**
     * @return int
     */
    public function getTradeCoinId(): ?int
    {
        return $this->tradeCoinId;
    }

    /**
     * @return string
     */
    public function getTradeCoinType(): ?string
    {
        return $this->tradeCoinType;
    }

    /**
     * @return int
     */
    public function getTradeTypeId(): ?int
    {
        return $this->tradeTypeId;
    }

    /**
     * @return int
     */
    public function getUid(): ?int
    {
        return $this->uid;
    }

}
