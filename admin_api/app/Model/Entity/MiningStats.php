<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 
 * Class MiningStats
 *
 * @since 2.0
 *
 * @Entity(table="mining_stats")
 */
class MiningStats extends Model
{
    /**
     * 今日购买人数
     *
     * @Column(name="buy_number", prop="buyNumber")
     *
     * @var int
     */
    private $buyNumber;

    /**
     * 币种类型
     *
     * @Column(name="coin_type", prop="coinType")
     *
     * @var string
     */
    private $coinType;

    /**
     * 创建时间
     *
     * @Column(name="created_at", prop="createdAt")
     *
     * @var string
     */
    private $createdAt;

    /**
     * 组id，一天一条数据
     *
     * @Column(name="group_id", prop="groupId")
     *
     * @var int
     */
    private $groupId;

    /**
     * 自增id
     * @Id()
     * @Column()
     *
     * @var int
     */
    private $id;

    /**
     * 今日用户总收益
     *
     * @Column()
     *
     * @var string
     */
    private $income;

    /**
     * 今日用户总收益 单位usdt
     *
     * @Column(name="income_usdt", prop="incomeUsdt")
     *
     * @var string
     */
    private $incomeUsdt;

    /**
     * 今日产出
     *
     * @Column()
     *
     * @var string
     */
    private $output;

    /**
     * 今日产出 单位usdt
     *
     * @Column(name="output_usdt", prop="outputUsdt")
     *
     * @var string
     */
    private $outputUsdt;

    /**
     * 重复购买人数
     *
     * @Column(name="rebuy_number", prop="rebuyNumber")
     *
     * @var int
     */
    private $rebuyNumber;

    /**
     * 今日交易hash
     *
     * @Column(name="trade_hash", prop="tradeHash")
     *
     * @var string
     */
    private $tradeHash;


    /**
     * @param int $buyNumber
     *
     * @return self
     */
    public function setBuyNumber(int $buyNumber): self
    {
        $this->buyNumber = $buyNumber;

        return $this;
    }

    /**
     * @param string $coinType
     *
     * @return self
     */
    public function setCoinType(string $coinType): self
    {
        $this->coinType = $coinType;

        return $this;
    }

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
     * @param int $groupId
     *
     * @return self
     */
    public function setGroupId(int $groupId): self
    {
        $this->groupId = $groupId;

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
     * @param string $income
     *
     * @return self
     */
    public function setIncome(string $income): self
    {
        $this->income = $income;

        return $this;
    }

    /**
     * @param string $incomeUsdt
     *
     * @return self
     */
    public function setIncomeUsdt(string $incomeUsdt): self
    {
        $this->incomeUsdt = $incomeUsdt;

        return $this;
    }

    /**
     * @param string $output
     *
     * @return self
     */
    public function setOutput(string $output): self
    {
        $this->output = $output;

        return $this;
    }

    /**
     * @param string $outputUsdt
     *
     * @return self
     */
    public function setOutputUsdt(string $outputUsdt): self
    {
        $this->outputUsdt = $outputUsdt;

        return $this;
    }

    /**
     * @param int $rebuyNumber
     *
     * @return self
     */
    public function setRebuyNumber(int $rebuyNumber): self
    {
        $this->rebuyNumber = $rebuyNumber;

        return $this;
    }

    /**
     * @param string $tradeHash
     *
     * @return self
     */
    public function setTradeHash(string $tradeHash): self
    {
        $this->tradeHash = $tradeHash;

        return $this;
    }

    /**
     * @return int
     */
    public function getBuyNumber(): ?int
    {
        return $this->buyNumber;
    }

    /**
     * @return string
     */
    public function getCoinType(): ?string
    {
        return $this->coinType;
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
    public function getGroupId(): ?int
    {
        return $this->groupId;
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
    public function getIncome(): ?string
    {
        return $this->income;
    }

    /**
     * @return string
     */
    public function getIncomeUsdt(): ?string
    {
        return $this->incomeUsdt;
    }

    /**
     * @return string
     */
    public function getOutput(): ?string
    {
        return $this->output;
    }

    /**
     * @return string
     */
    public function getOutputUsdt(): ?string
    {
        return $this->outputUsdt;
    }

    /**
     * @return int
     */
    public function getRebuyNumber(): ?int
    {
        return $this->rebuyNumber;
    }

    /**
     * @return string
     */
    public function getTradeHash(): ?string
    {
        return $this->tradeHash;
    }

}
