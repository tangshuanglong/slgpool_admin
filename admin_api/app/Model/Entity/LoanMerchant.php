<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 
 * Class LoanMerchant
 *
 * @since 2.0
 *
 * @Entity(table="loan_merchant")
 */
class LoanMerchant extends Model
{
    /**
     * 借入次数
     *
     * @Column(name="borrow_times", prop="borrowTimes")
     *
     * @var int
     */
    private $borrowTimes;

    /**
     * 创建时间
     *
     * @Column(name="create_time", prop="createTime")
     *
     * @var int
     */
    private $createTime;

    /**
     * 自增id
     * @Id()
     * @Column()
     *
     * @var int
     */
    private $id;

    /**
     * 贷出次数
     *
     * @Column(name="loan_out_times", prop="loanOutTimes")
     *
     * @var int
     */
    private $loanOutTimes;

    /**
     * 商人名称
     *
     * @Column(name="nick_name", prop="nickName")
     *
     * @var string
     */
    private $nickName;

    /**
     * 用户id
     *
     * @Column()
     *
     * @var int
     */
    private $uid;


    /**
     * @param int $borrowTimes
     *
     * @return self
     */
    public function setBorrowTimes(int $borrowTimes): self
    {
        $this->borrowTimes = $borrowTimes;

        return $this;
    }

    /**
     * @param int $createTime
     *
     * @return self
     */
    public function setCreateTime(int $createTime): self
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
     * @param int $loanOutTimes
     *
     * @return self
     */
    public function setLoanOutTimes(int $loanOutTimes): self
    {
        $this->loanOutTimes = $loanOutTimes;

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
    public function getBorrowTimes(): ?int
    {
        return $this->borrowTimes;
    }

    /**
     * @return int
     */
    public function getCreateTime(): ?int
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
     * @return int
     */
    public function getLoanOutTimes(): ?int
    {
        return $this->loanOutTimes;
    }

    /**
     * @return string
     */
    public function getNickName(): ?string
    {
        return $this->nickName;
    }

    /**
     * @return int
     */
    public function getUid(): ?int
    {
        return $this->uid;
    }

}
