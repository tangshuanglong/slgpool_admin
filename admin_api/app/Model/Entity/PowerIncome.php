<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 *
 * Class PowerIncome
 *
 * @since 2.0
 *
 * @Entity(table="power_income")
 */
class PowerIncome extends Model
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
     * 0 为init类型，1为预估收益，2.实际发放，用户可以看到可以提取
     *
     * @Column(name="income_type", prop="incomeType")
     *
     * @var int
     */
    private $incomeType;

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
     * @param int $incomeType
     *
     * @return self
     */
    public function setIncomeType(int $incomeType): self
    {
        $this->incomeType = $incomeType;

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
     * @return int
     */
    public function getIncomeType(): ?int
    {
        return $this->incomeType;
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
