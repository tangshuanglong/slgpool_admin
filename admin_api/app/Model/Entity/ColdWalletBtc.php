<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 
 * Class ColdWalletBtc
 *
 * @since 2.0
 *
 * @Entity(table="cold_wallet_btc")
 */
class ColdWalletBtc extends Model
{
    /**
     * 账户名(可选填)
     *
     * @Column()
     *
     * @var string
     */
    private $account;

    /**
     * 充值地址
     *
     * @Column()
     *
     * @var string
     */
    private $address;

    /**
     * 余额(选填)
     *
     * @Column()
     *
     * @var string
     */
    private $balance;

    /**
     * 创建时间
     *
     * @Column(name="create_time", prop="createTime")
     *
     * @var int
     */
    private $createTime;

    /**
     * 
     * @Id()
     * @Column()
     *
     * @var int
     */
    private $id;

    /**
     * 下次查询的起始区块(选填)
     *
     * @Column(name="next_start", prop="nextStart")
     *
     * @var int
     */
    private $nextStart;

    /**
     * 私钥
     *
     * @Column(name="private_key", prop="privateKey")
     *
     * @var string
     */
    private $privateKey;

    /**
     * 访问充值页面时的时间
     *
     * @Column(name="ready_time", prop="readyTime")
     *
     * @var int
     */
    private $readyTime;

    /**
     * 用户ID
     *
     * @Column()
     *
     * @var int|null
     */
    private $uid;

    /**
     * 更新时间
     *
     * @Column(name="update_time", prop="updateTime")
     *
     * @var int
     */
    private $updateTime;


    /**
     * @param string $account
     *
     * @return self
     */
    public function setAccount(string $account): self
    {
        $this->account = $account;

        return $this;
    }

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
     * @param string $balance
     *
     * @return self
     */
    public function setBalance(string $balance): self
    {
        $this->balance = $balance;

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
     * @param int $nextStart
     *
     * @return self
     */
    public function setNextStart(int $nextStart): self
    {
        $this->nextStart = $nextStart;

        return $this;
    }

    /**
     * @param string $privateKey
     *
     * @return self
     */
    public function setPrivateKey(string $privateKey): self
    {
        $this->privateKey = $privateKey;

        return $this;
    }

    /**
     * @param int $readyTime
     *
     * @return self
     */
    public function setReadyTime(int $readyTime): self
    {
        $this->readyTime = $readyTime;

        return $this;
    }

    /**
     * @param int|null $uid
     *
     * @return self
     */
    public function setUid(?int $uid): self
    {
        $this->uid = $uid;

        return $this;
    }

    /**
     * @param int $updateTime
     *
     * @return self
     */
    public function setUpdateTime(int $updateTime): self
    {
        $this->updateTime = $updateTime;

        return $this;
    }

    /**
     * @return string
     */
    public function getAccount(): ?string
    {
        return $this->account;
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
    public function getBalance(): ?string
    {
        return $this->balance;
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
    public function getNextStart(): ?int
    {
        return $this->nextStart;
    }

    /**
     * @return string
     */
    public function getPrivateKey(): ?string
    {
        return $this->privateKey;
    }

    /**
     * @return int
     */
    public function getReadyTime(): ?int
    {
        return $this->readyTime;
    }

    /**
     * @return int|null
     */
    public function getUid(): ?int
    {
        return $this->uid;
    }

    /**
     * @return int
     */
    public function getUpdateTime(): ?int
    {
        return $this->updateTime;
    }

}
