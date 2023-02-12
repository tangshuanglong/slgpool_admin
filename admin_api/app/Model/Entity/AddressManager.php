<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 
 * Class AddressManager
 *
 * @since 2.0
 *
 * @Entity(table="address_manager")
 */
class AddressManager extends Model
{
    /**
     * 区块链地址或账号
     *
     * @Column()
     *
     * @var string
     */
    private $address;

    /**
     * 公链名称，默认币种名称
     *
     * @Column(name="chain_name", prop="chainName")
     *
     * @var string
     */
    private $chainName;

    /**
     * 币种名称
     *
     * @Column(name="coin_name", prop="coinName")
     *
     * @var string
     */
    private $coinName;

    /**
     * 创建时间
     *
     * @Column(name="create_time", prop="createTime")
     *
     * @var int
     */
    private $createTime;

    /**
     * 地址管理表
     * @Id()
     * @Column()
     *
     * @var int
     */
    private $id;

    /**
     * 标签，石墨烯链才需要，如eos
     *
     * @Column()
     *
     * @var string
     */
    private $memo;

    /**
     * 备注
     *
     * @Column()
     *
     * @var string
     */
    private $remark;

    /**
     * 用户id
     *
     * @Column()
     *
     * @var int
     */
    private $uid;


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
     * @param string $memo
     *
     * @return self
     */
    public function setMemo(string $memo): self
    {
        $this->memo = $memo;

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
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @return string
     */
    public function getChainName(): ?string
    {
        return $this->chainName;
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
     * @return string
     */
    public function getMemo(): ?string
    {
        return $this->memo;
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
    public function getUid(): ?int
    {
        return $this->uid;
    }

}
