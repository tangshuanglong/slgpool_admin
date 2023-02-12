<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 
 * Class MiningIncome
 *
 * @since 2.0
 *
 * @Entity(table="mining_income")
 */
class MiningIncome extends Model
{
    /**
     * 币种类型
     *
     * @Column(name="coin_type", prop="coinType")
     *
     * @var string
     */
    private $coinType;

    /**
     * 发放时间
     *
     * @Column(name="created_at", prop="createdAt")
     *
     * @var string
     */
    private $createdAt;

    /**
     * 自增id
     * @Id()
     * @Column()
     *
     * @var int
     */
    private $id;

    /**
     * 挖矿收益
     *
     * @Column()
     *
     * @var string
     */
    private $income;

    /**
     * 收益奖励，奖励平台币 单位：bsf
     *
     * @Column(name="income_reward", prop="incomeReward")
     *
     * @var string
     */
    private $incomeReward;

    /**
     * 订单id
     *
     * @Column(name="order_id", prop="orderId")
     *
     * @var int
     */
    private $orderId;

    /**
     * 类型，1-矿机，2-算力
     *
     * @Column(name="product_type", prop="productType")
     *
     * @var int
     */
    private $productType;

    /**
     * 用户id
     *
     * @Column()
     *
     * @var int
     */
    private $uid;


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
     * @param string $incomeReward
     *
     * @return self
     */
    public function setIncomeReward(string $incomeReward): self
    {
        $this->incomeReward = $incomeReward;

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
     * @param int $productType
     *
     * @return self
     */
    public function setProductType(int $productType): self
    {
        $this->productType = $productType;

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
    public function getIncomeReward(): ?string
    {
        return $this->incomeReward;
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
    public function getProductType(): ?int
    {
        return $this->productType;
    }

    /**
     * @return int
     */
    public function getUid(): ?int
    {
        return $this->uid;
    }

}
