<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 系统提现记录
 * Class CoinWithdrawSysLog
 *
 * @since 2.0
 *
 * @Entity(table="coin_withdraw_sys_log")
 */
class CoinWithdrawSysLog extends Model
{
    /**
     * sender地址
     *
     * @Column()
     *
     * @var string
     */
    private $address;

    /**
     * 提现数量
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
     * cold wallet id
     *
     * @Column()
     *
     * @var int
     */
    private $cid;

    /**
     * 币种ID
     *
     * @Column(name="coin_id", prop="coinId")
     *
     * @var int
     */
    private $coinId;

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
     * 210：等待区块确认 280：区块确认 400：失败
     *
     * @Column()
     *
     * @var int
     */
    private $status;

    /**
     * receiver address
     *
     * @Column(name="to_address", prop="toAddress")
     *
     * @var string
     */
    private $toAddress;

    /**
     * coin token id
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
     * @var string|null
     */
    private $txHash;

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
     * @param int $cid
     *
     * @return self
     */
    public function setCid(int $cid): self
    {
        $this->cid = $cid;

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
     * @param string $toAddress
     *
     * @return self
     */
    public function setToAddress(string $toAddress): self
    {
        $this->toAddress = $toAddress;

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
     * @param string|null $txHash
     *
     * @return self
     */
    public function setTxHash(?string $txHash): self
    {
        $this->txHash = $txHash;

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
    public function getCid(): ?int
    {
        return $this->cid;
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
    public function getStatus(): ?int
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getToAddress(): ?string
    {
        return $this->toAddress;
    }

    /**
     * @return int
     */
    public function getTokenId(): ?int
    {
        return $this->tokenId;
    }

    /**
     * @return string|null
     */
    public function getTxHash(): ?string
    {
        return $this->txHash;
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

}
