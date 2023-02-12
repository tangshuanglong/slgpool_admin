<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 公链表
 * Class Chain
 *
 * @since 2.0
 *
 * @Entity(table="chain")
 */
class Chain extends Model
{
    /**
     * 是否撤销，0代表未撤销，1代表已撤销
     *
     * @Column(name="cancel_flag", prop="cancelFlag")
     *
     * @var int
     */
    private $cancelFlag;

    /**
     * 公链名
     *
     * @Column(name="chain_name", prop="chainName")
     *
     * @var string
     */
    private $chainName;

    /**
     * 区块确认数
     *
     * @Column(name="confirmation_time", prop="confirmationTime")
     *
     * @var int
     */
    private $confirmationTime;

    /**
     * 创建时间
     *
     * @Column(name="created_at", prop="createdAt")
     *
     * @var string
     */
    private $createdAt;

    /**
     * 
     * @Id()
     * @Column()
     *
     * @var int
     */
    private $id;

    /**
     * 是否匿名
     *
     * @Column(name="is_anonymous", prop="isAnonymous")
     *
     * @var int
     */
    private $isAnonymous;

    /**
     * 是否基于石墨烯技术(充值地址的展示会不一样)
     *
     * @Column(name="is_graphene", prop="isGraphene")
     *
     * @var int
     */
    private $isGraphene;

    /**
     * 下次历史交易查询起点
     *
     * @Column(name="next_start_sequence", prop="nextStartSequence")
     *
     * @var int
     */
    private $nextStartSequence;

    /**
     * 冷钱包地址/账户名
     *
     * @Column(name="system_cold_wallet", prop="systemColdWallet")
     *
     * @var string
     */
    private $systemColdWallet;

    /**
     * 热钱包地址/账户名
     *
     * @Column(name="system_hot_wallet", prop="systemHotWallet")
     *
     * @var string
     */
    private $systemHotWallet;

    /**
     * 更新时间
     *
     * @Column(name="updated_at", prop="updatedAt")
     *
     * @var string
     */
    private $updatedAt;


    /**
     * @param int $cancelFlag
     *
     * @return self
     */
    public function setCancelFlag(int $cancelFlag): self
    {
        $this->cancelFlag = $cancelFlag;

        return $this;
    }

    /**
     * @param string $chainName
     *
     * @return self
     */
    public function setChainName(string $chainName): self
    {
        $this->chainName = $chainName;

        return $this;
    }

    /**
     * @param int $confirmationTime
     *
     * @return self
     */
    public function setConfirmationTime(int $confirmationTime): self
    {
        $this->confirmationTime = $confirmationTime;

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
     * @param int $isAnonymous
     *
     * @return self
     */
    public function setIsAnonymous(int $isAnonymous): self
    {
        $this->isAnonymous = $isAnonymous;

        return $this;
    }

    /**
     * @param int $isGraphene
     *
     * @return self
     */
    public function setIsGraphene(int $isGraphene): self
    {
        $this->isGraphene = $isGraphene;

        return $this;
    }

    /**
     * @param int $nextStartSequence
     *
     * @return self
     */
    public function setNextStartSequence(int $nextStartSequence): self
    {
        $this->nextStartSequence = $nextStartSequence;

        return $this;
    }

    /**
     * @param string $systemColdWallet
     *
     * @return self
     */
    public function setSystemColdWallet(string $systemColdWallet): self
    {
        $this->systemColdWallet = $systemColdWallet;

        return $this;
    }

    /**
     * @param string $systemHotWallet
     *
     * @return self
     */
    public function setSystemHotWallet(string $systemHotWallet): self
    {
        $this->systemHotWallet = $systemHotWallet;

        return $this;
    }

    /**
     * @param string $updatedAt
     *
     * @return self
     */
    public function setUpdatedAt(string $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return int
     */
    public function getCancelFlag(): ?int
    {
        return $this->cancelFlag;
    }

    /**
     * @return string
     */
    public function getChainName(): ?string
    {
        return $this->chainName;
    }

    /**
     * @return int
     */
    public function getConfirmationTime(): ?int
    {
        return $this->confirmationTime;
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
    public function getIsAnonymous(): ?int
    {
        return $this->isAnonymous;
    }

    /**
     * @return int
     */
    public function getIsGraphene(): ?int
    {
        return $this->isGraphene;
    }

    /**
     * @return int
     */
    public function getNextStartSequence(): ?int
    {
        return $this->nextStartSequence;
    }

    /**
     * @return string
     */
    public function getSystemColdWallet(): ?string
    {
        return $this->systemColdWallet;
    }

    /**
     * @return string
     */
    public function getSystemHotWallet(): ?string
    {
        return $this->systemHotWallet;
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

}
