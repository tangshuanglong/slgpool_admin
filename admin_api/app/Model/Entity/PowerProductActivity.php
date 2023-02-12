<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 
 * Class PowerProductActivity
 *
 * @since 2.0
 *
 * @Entity(table="power_product_activity")
 */
class PowerProductActivity extends Model
{
    /**
     * 库存卖出多少之后
     *
     * @Column(name="after_quantity", prop="afterQuantity")
     *
     * @var int
     */
    private $afterQuantity;

    /**
     * 库存卖出多少之前
     *
     * @Column(name="before_quantity", prop="beforeQuantity")
     *
     * @var int
     */
    private $beforeQuantity;

    /**
     * 创建时间
     *
     * @Column(name="created_at", prop="createdAt")
     *
     * @var string
     */
    private $createdAt;

    /**
     * 自增ID
     * @Id()
     * @Column()
     *
     * @var int
     */
    private $id;

    /**
     * 产品ID
     *
     * @Column(name="product_id", prop="productId")
     *
     * @var int
     */
    private $productId;

    /**
     * 奖励算力比例
     *
     * @Column(name="reward_ratio", prop="rewardRatio")
     *
     * @var string
     */
    private $rewardRatio;

    /**
     * 状态，1-开启，0-关闭
     *
     * @Column(name="status_flag", prop="statusFlag")
     *
     * @var int
     */
    private $statusFlag;


    /**
     * @param int $afterQuantity
     *
     * @return self
     */
    public function setAfterQuantity(int $afterQuantity): self
    {
        $this->afterQuantity = $afterQuantity;

        return $this;
    }

    /**
     * @param int $beforeQuantity
     *
     * @return self
     */
    public function setBeforeQuantity(int $beforeQuantity): self
    {
        $this->beforeQuantity = $beforeQuantity;

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
     * @param int $productId
     *
     * @return self
     */
    public function setProductId(int $productId): self
    {
        $this->productId = $productId;

        return $this;
    }

    /**
     * @param string $rewardRatio
     *
     * @return self
     */
    public function setRewardRatio(string $rewardRatio): self
    {
        $this->rewardRatio = $rewardRatio;

        return $this;
    }

    /**
     * @param int $statusFlag
     *
     * @return self
     */
    public function setStatusFlag(int $statusFlag): self
    {
        $this->statusFlag = $statusFlag;

        return $this;
    }

    /**
     * @return int
     */
    public function getAfterQuantity(): ?int
    {
        return $this->afterQuantity;
    }

    /**
     * @return int
     */
    public function getBeforeQuantity(): ?int
    {
        return $this->beforeQuantity;
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
     * @return int
     */
    public function getProductId(): ?int
    {
        return $this->productId;
    }

    /**
     * @return string
     */
    public function getRewardRatio(): ?string
    {
        return $this->rewardRatio;
    }

    /**
     * @return int
     */
    public function getStatusFlag(): ?int
    {
        return $this->statusFlag;
    }

}
