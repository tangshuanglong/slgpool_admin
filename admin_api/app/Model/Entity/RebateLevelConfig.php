<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 邀请返佣等级
 * Class RebateLevelConfig
 *
 * @since 2.0
 *
 * @Entity(table="rebate_level_config")
 */
class RebateLevelConfig extends Model
{
    /**
     * 币种
     *
     * @Column(name="coin_type", prop="coinType")
     *
     * @var string|null
     */
    private $coinType;

    /**
     * 消费金额在多少之后
     *
     * @Column(name="consume_after", prop="consumeAfter")
     *
     * @var string|null
     */
    private $consumeAfter;

    /**
     * 消费金额在多少之前
     *
     * @Column(name="consume_before", prop="consumeBefore")
     *
     * @var string|null
     */
    private $consumeBefore;

    /**
     * 创建时间
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
     * 等级
     *
     * @Column()
     *
     * @var int
     */
    private $level;

    /**
     * 返佣比例
     *
     * @Column()
     *
     * @var string
     */
    private $rebate;

    /**
     * 挖矿产出比例
     *
     * @Column(name="rebate_mining", prop="rebateMining")
     *
     * @var string
     */
    private $rebateMining;

    /**
     * 单位
     *
     * @Column()
     *
     * @var string|null
     */
    private $unit;


    /**
     * @param string|null $coinType
     *
     * @return self
     */
    public function setCoinType(?string $coinType): self
    {
        $this->coinType = $coinType;

        return $this;
    }

    /**
     * @param string|null $consumeAfter
     *
     * @return self
     */
    public function setConsumeAfter(?string $consumeAfter): self
    {
        $this->consumeAfter = $consumeAfter;

        return $this;
    }

    /**
     * @param string|null $consumeBefore
     *
     * @return self
     */
    public function setConsumeBefore(?string $consumeBefore): self
    {
        $this->consumeBefore = $consumeBefore;

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
     * @param int $level
     *
     * @return self
     */
    public function setLevel(int $level): self
    {
        $this->level = $level;

        return $this;
    }

    /**
     * @param string $rebate
     *
     * @return self
     */
    public function setRebate(string $rebate): self
    {
        $this->rebate = $rebate;

        return $this;
    }

    /**
     * @param string $rebateMining
     *
     * @return self
     */
    public function setRebateMining(string $rebateMining): self
    {
        $this->rebateMining = $rebateMining;

        return $this;
    }

    /**
     * @param string|null $unit
     *
     * @return self
     */
    public function setUnit(?string $unit): self
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCoinType(): ?string
    
    {
        return $this->coinType;
    }

    /**
     * @return string|null
     */
    public function getConsumeAfter(): ?string
    
    {
        return $this->consumeAfter;
    }

    /**
     * @return string|null
     */
    public function getConsumeBefore(): ?string
    
    {
        return $this->consumeBefore;
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
    public function getLevel(): ?int
    
    {
        return $this->level;
    }

    /**
     * @return string
     */
    public function getRebate(): ?string
    
    {
        return $this->rebate;
    }

    /**
     * @return string
     */
    public function getRebateMining(): ?string
    
    {
        return $this->rebateMining;
    }

    /**
     * @return string|null
     */
    public function getUnit(): ?string
    
    {
        return $this->unit;
    }


}
