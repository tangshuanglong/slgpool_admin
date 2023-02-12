<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 币种充值表
 * Class CoinDepositLog
 *
 * @since 2.0
 *
 * @Entity(table="coin_deposit_log")
 */
class CoinDepositLog extends Model
{
    /**
     * 充进地址
     *
     * @Column()
     *
     * @var string
     */
    private $address;

    /**
     * 充值数量
     *
     * @Column()
     *
     * @var string
     */
    private $amount;

    /**
     * 公链ID
     *
     * @Column(name="chain_id", prop="chainId")
     *
     * @var int
     */
    private $chainId;

    /**
     * 币种ID
     *
     * @Column(name="coin_id", prop="coinId")
     *
     * @var int
     */
    private $coinId;

    /**
     * 币种名
     *
     * @Column(name="coin_name", prop="coinName")
     *
     * @var string
     */
    private $coinName;

    /**
     * 区块确认数
     *
     * @Column()
     *
     * @var int
     */
    private $confirmations;

    /**
     * 记录创建时间
     *
     * @Column(name="created_at", prop="createdAt")
     *
     * @var string
     */
    private $createdAt;

    /**
     * 充值流水号
     *
     * @Column(name="deposit_number", prop="depositNumber")
     *
     * @var string
     */
    private $depositNumber;

    /**
     * 
     * @Id()
     * @Column()
     *
     * @var int
     */
    private $id;

    /**
     * 是否被系统提现
     *
     * @Column(name="is_withdrawed", prop="isWithdrawed")
     *
     * @var int
     */
    private $isWithdrawed;

    /**
     * 备注
     *
     * @Column()
     *
     * @var string
     */
    private $remark;

    /**
     * 100:区块确认中  200:已确认并入账 300:充值失败
     *
     * @Column()
     *
     * @var int
     */
    private $status;

    /**
     * token id
     *
     * @Column(name="token_id", prop="tokenId")
     *
     * @var int
     */
    private $tokenId;

    /**
     * 交易hash
     *
     * @Column(name="tx_hash", prop="txHash")
     *
     * @var string
     */
    private $txHash;

    /**
     * 用户id
     *
     * @Column()
     *
     * @var int
     */
    private $uid;

    /**
     * 更新时间
     *
     * @Column(name="updated_at", prop="updatedAt")
     *
     * @var string
     */
    private $updatedAt;


    /**
     * @param string $address
     *
     * @return self
     */
    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @param string $amount
     *
     * @return self
     */
    public function setAmount(string $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @param int $chainId
     *
     * @return self
     */
    public function setChainId(int $chainId): self
    {
        $this->chainId = $chainId;

        return $this;
    }

    /**
     * @param int $coinId
     *
     * @return self
     */
    public function setCoinId(int $coinId): self
    {
        $this->coinId = $coinId;

        return $this;
    }

    /**
     * @param string $coinName
     *
     * @return self
     */
    public function setCoinName(string $coinName): self
    {
        $this->coinName = $coinName;

        return $this;
    }

    /**
     * @param int $confirmations
     *
     * @return self
     */
    public function setConfirmations(int $confirmations): self
    {
        $this->confirmations = $confirmations;

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
     * @param string $depositNumber
     *
     * @return self
     */
    public function setDepositNumber(string $depositNumber): self
    {
        $this->depositNumber = $depositNumber;

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
     * @param int $isWithdrawed
     *
     * @return self
     */
    public function setIsWithdrawed(int $isWithdrawed): self
    {
        $this->isWithdrawed = $isWithdrawed;

        return $this;
    }

    /**
     * @param string $remark
     *
     * @return self
     */
    public function setRemark(string $remark): self
    {
        $this->remark = $remark;

        return $this;
    }

    /**
     * @param int $status
     *
     * @return self
     */
    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @param int $tokenId
     *
     * @return self
     */
    public function setTokenId(int $tokenId): self
    {
        $this->tokenId = $tokenId;

        return $this;
    }

    /**
     * @param string $txHash
     *
     * @return self
     */
    public function setTxHash(string $txHash): self
    {
        $this->txHash = $txHash;

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
     * @return string
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @return string
     */
    public function getAmount(): ?string
    {
        return $this->amount;
    }

    /**
     * @return int
     */
    public function getChainId(): ?int
    {
        return $this->chainId;
    }

    /**
     * @return int
     */
    public function getCoinId(): ?int
    {
        return $this->coinId;
    }

    /**
     * @return string
     */
    public function getCoinName(): ?string
    {
        return $this->coinName;
    }

    /**
     * @return int
     */
    public function getConfirmations(): ?int
    {
        return $this->confirmations;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * @return string
     */
    public function getDepositNumber(): ?string
    {
        return $this->depositNumber;
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
    public function getIsWithdrawed(): ?int
    {
        return $this->isWithdrawed;
    }

    /**
     * @return string
     */
    public function getRemark(): ?string
    {
        return $this->remark;
    }

    /**
     * @return int
     */
    public function getStatus(): ?int
    {
        return $this->status;
    }

    /**
     * @return int
     */
    public function getTokenId(): ?int
    {
        return $this->tokenId;
    }

    /**
     * @return string
     */
    public function getTxHash(): ?string
    {
        return $this->txHash;
    }

    /**
     * @return int
     */
    public function getUid(): ?int
    {
        return $this->uid;
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

}
