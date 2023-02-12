<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 
 * Class PowerIncomeLog
 *
 * @since 2.0
 *
 * @Entity(table="power_income_log")
 */
class PowerIncomeLog extends Model
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
     * 分润列表
     *
     * @Column(name="income_id", prop="incomeId")
     *
     * @var int
     */
    private $incomeId;

    /**
     * 类的 序列化
     *
     * @Column()
     *
     * @var string
     */
    private $serializable;


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
     * @param int $incomeId
     *
     * @return self
     */
    public function setIncomeId(int $incomeId): self
    {
        $this->incomeId = $incomeId;

        return $this;
    }

    /**
     * @param string $serializable
     *
     * @return self
     */
    public function setSerializable(string $serializable): self
    {
        $this->serializable = $serializable;

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
    public function getIncomeId(): ?int
    {
        return $this->incomeId;
    }

    /**
     * @return string
     */
    public function getSerializable(): ?string
    {
        return $this->serializable;
    }

}
