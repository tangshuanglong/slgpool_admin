<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 
 * Class UserForbiddenLog
 *
 * @since 2.0
 *
 * @Entity(table="user_forbidden_log")
 */
class UserForbiddenLog extends Model
{
    /**
     * 禁止时长
     *
     * @Column(name="forbidden_duration", prop="forbiddenDuration")
     *
     * @var int
     */
    private $forbiddenDuration;

    /**
     * 解禁时间
     *
     * @Column(name="forbidden_end_time", prop="forbiddenEndTime")
     *
     * @var int
     */
    private $forbiddenEndTime;

    /**
     * 禁止操作的次数
     *
     * @Column(name="forbidden_flag", prop="forbiddenFlag")
     *
     * @var int
     */
    private $forbiddenFlag;

    /**
     * 禁止访问的原因, 1-登录失败次数过多
     *
     * @Column(name="forbidden_reason", prop="forbiddenReason")
     *
     * @var int
     */
    private $forbiddenReason;

    /**
     * 禁止操作发生时的操作时间
     *
     * @Column(name="forbidden_start_time", prop="forbiddenStartTime")
     *
     * @var int
     */
    private $forbiddenStartTime;

    /**
     * 用户禁止访问信息
     * @Id()
     * @Column()
     *
     * @var int
     */
    private $id;

    /**
     * 用户ID
     *
     * @Column()
     *
     * @var int
     */
    private $uid;


    /**
     * @param int $forbiddenDuration
     *
     * @return self
     */
    public function setForbiddenDuration(int $forbiddenDuration): self
    {
        $this->forbiddenDuration = $forbiddenDuration;

        return $this;
    }

    /**
     * @param int $forbiddenEndTime
     *
     * @return self
     */
    public function setForbiddenEndTime(int $forbiddenEndTime): self
    {
        $this->forbiddenEndTime = $forbiddenEndTime;

        return $this;
    }

    /**
     * @param int $forbiddenFlag
     *
     * @return self
     */
    public function setForbiddenFlag(int $forbiddenFlag): self
    {
        $this->forbiddenFlag = $forbiddenFlag;

        return $this;
    }

    /**
     * @param int $forbiddenReason
     *
     * @return self
     */
    public function setForbiddenReason(int $forbiddenReason): self
    {
        $this->forbiddenReason = $forbiddenReason;

        return $this;
    }

    /**
     * @param int $forbiddenStartTime
     *
     * @return self
     */
    public function setForbiddenStartTime(int $forbiddenStartTime): self
    {
        $this->forbiddenStartTime = $forbiddenStartTime;

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
     * @return int
     */
    public function getForbiddenDuration(): ?int
    {
        return $this->forbiddenDuration;
    }

    /**
     * @return int
     */
    public function getForbiddenEndTime(): ?int
    {
        return $this->forbiddenEndTime;
    }

    /**
     * @return int
     */
    public function getForbiddenFlag(): ?int
    {
        return $this->forbiddenFlag;
    }

    /**
     * @return int
     */
    public function getForbiddenReason(): ?int
    {
        return $this->forbiddenReason;
    }

    /**
     * @return int
     */
    public function getForbiddenStartTime(): ?int
    {
        return $this->forbiddenStartTime;
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
    public function getUid(): ?int
    {
        return $this->uid;
    }

}
