<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 
 * Class CoinToken
 *
 * @since 2.0
 *
 * @Entity(table="coin_token")
 */
class CoinToken extends Model
{
    /**
     * 账户名
     *
     * @Column(name="account_name", prop="accountName")
     *
     * @var string
     */
    private $accountName;

    /**
     * 资产ID(选填)
     *
     * @Column(name="asset_id", prop="assetId")
     *
     * @var string|null
     */
    private $assetId;

    /**
     * 是否撤销，默认为0，取消则设置为1
     *
     * @Column(name="cancel_flag", prop="cancelFlag")
     *
     * @var int|null
     */
    private $cancelFlag;

    /**
     * 公链id
     *
     * @Column(name="chain_id", prop="chainId")
     *
     * @var int
     */
    private $chainId;

    /**
     * 币种ID，详情可查看hcf_coin表
     *
     * @Column(name="coin_id", prop="coinId")
     *
     * @var int
     */
    private $coinId;

    /**
     * 币种英文名缩写
     *
     * @Column(name="coin_name", prop="coinName")
     *
     * @var string
     */
    private $coinName;

    /**
     * 币种系列ID
     *
     * @Column(name="coin_serials_id", prop="coinSerialsId")
     *
     * @var int|null
     */
    private $coinSerialsId;

    /**
     * 合约对象方法的abi
     *
     * @Column(name="contract_abi", prop="contractAbi")
     *
     * @var string|null
     */
    private $contractAbi;

    /**
     * 币种合约地址
     *
     * @Column(name="contract_address", prop="contractAddress")
     *
     * @var string|null
     */
    private $contractAddress;

    /**
     * 创建时间
     *
     * @Column(name="created_at", prop="createdAt")
     *
     * @var string
     */
    private $createdAt;

    /**
     * 小数点位数
     *
     * @Column()
     *
     * @var int|null
     */
    private $decimals;

    /**
     * token显示名称
     *
     * @Column(name="display_name", prop="displayName")
     *
     * @var string
     */
    private $displayName;

    /**
     * 区块链浏览器地址
     *
     * @Column(name="explorer_url", prop="explorerUrl")
     *
     * @var string
     */
    private $explorerUrl;

    /**
     * url里面的address写法，用于拼接查看区块链记录的url用的
     *
     * @Column(name="explorer_url_parameter_address", prop="explorerUrlParameterAddress")
     *
     * @var string
     */
    private $explorerUrlParameterAddress;

    /**
     * url里面的tx写法，用于拼接查看区块链记录的url用的
     *
     * @Column(name="explorer_url_parameter_tx", prop="explorerUrlParameterTx")
     *
     * @var string
     */
    private $explorerUrlParameterTx;

    /**
     * 
     * @Id()
     * @Column()
     *
     * @var int
     */
    private $id;

    /**
     * 是否主代币
     *
     * @Column(name="is_main", prop="isMain")
     *
     * @var int
     */
    private $isMain;

    /**
     * 最大提币数量
     *
     * @Column(name="max_withdraw", prop="maxWithdraw")
     *
     * @var string
     */
    private $maxWithdraw;

    /**
     * 最小充值数量
     *
     * @Column(name="min_deposit", prop="minDeposit")
     *
     * @var string
     */
    private $minDeposit;

    /**
     * 最小提币数量
     *
     * @Column(name="min_withdraw", prop="minWithdraw")
     *
     * @var string
     */
    private $minWithdraw;

    /**
     * 属性id
     *
     * @Column(name="property_id", prop="propertyId")
     *
     * @var int
     */
    private $propertyId;

    /**
     * 更新时间
     *
     * @Column(name="updated_at", prop="updatedAt")
     *
     * @var string
     */
    private $updatedAt;

    /**
     * 热钱包数量预警值
     *
     * @Column(name="warning_amount", prop="warningAmount")
     *
     * @var string
     */
    private $warningAmount;

    /**
     * 提现手续费
     *
     * @Column(name="withdraw_fee", prop="withdrawFee")
     *
     * @var string
     */
    private $withdrawFee;

    /**
     * 提现阔值
     *
     * @Column(name="withdraw_theshold", prop="withdrawTheshold")
     *
     * @var string
     */
    private $withdrawTheshold;


    /**
     * @param string $accountName
     *
     * @return self
     */
    public function setAccountName(string $accountName): self
    {
        $this->accountName = $accountName;

        return $this;
    }

    /**
     * @param string|null $assetId
     *
     * @return self
     */
    public function setAssetId(?string $assetId): self
    {
        $this->assetId = $assetId;

        return $this;
    }

    /**
     * @param int|null $cancelFlag
     *
     * @return self
     */
    public function setCancelFlag(?int $cancelFlag): self
    {
        $this->cancelFlag = $cancelFlag;

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
     * @param int|null $coinSerialsId
     *
     * @return self
     */
    public function setCoinSerialsId(?int $coinSerialsId): self
    {
        $this->coinSerialsId = $coinSerialsId;

        return $this;
    }

    /**
     * @param string|null $contractAbi
     *
     * @return self
     */
    public function setContractAbi(?string $contractAbi): self
    {
        $this->contractAbi = $contractAbi;

        return $this;
    }

    /**
     * @param string|null $contractAddress
     *
     * @return self
     */
    public function setContractAddress(?string $contractAddress): self
    {
        $this->contractAddress = $contractAddress;

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
     * @param int|null $decimals
     *
     * @return self
     */
    public function setDecimals(?int $decimals): self
    {
        $this->decimals = $decimals;

        return $this;
    }

    /**
     * @param string $displayName
     *
     * @return self
     */
    public function setDisplayName(string $displayName): self
    {
        $this->displayName = $displayName;

        return $this;
    }

    /**
     * @param string $explorerUrl
     *
     * @return self
     */
    public function setExplorerUrl(string $explorerUrl): self
    {
        $this->explorerUrl = $explorerUrl;

        return $this;
    }

    /**
     * @param string $explorerUrlParameterAddress
     *
     * @return self
     */
    public function setExplorerUrlParameterAddress(string $explorerUrlParameterAddress): self
    {
        $this->explorerUrlParameterAddress = $explorerUrlParameterAddress;

        return $this;
    }

    /**
     * @param string $explorerUrlParameterTx
     *
     * @return self
     */
    public function setExplorerUrlParameterTx(string $explorerUrlParameterTx): self
    {
        $this->explorerUrlParameterTx = $explorerUrlParameterTx;

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
     * @param int $isMain
     *
     * @return self
     */
    public function setIsMain(int $isMain): self
    {
        $this->isMain = $isMain;

        return $this;
    }

    /**
     * @param string $maxWithdraw
     *
     * @return self
     */
    public function setMaxWithdraw(string $maxWithdraw): self
    {
        $this->maxWithdraw = $maxWithdraw;

        return $this;
    }

    /**
     * @param string $minDeposit
     *
     * @return self
     */
    public function setMinDeposit(string $minDeposit): self
    {
        $this->minDeposit = $minDeposit;

        return $this;
    }

    /**
     * @param string $minWithdraw
     *
     * @return self
     */
    public function setMinWithdraw(string $minWithdraw): self
    {
        $this->minWithdraw = $minWithdraw;

        return $this;
    }

    /**
     * @param int $propertyId
     *
     * @return self
     */
    public function setPropertyId(int $propertyId): self
    {
        $this->propertyId = $propertyId;

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
     * @param string $warningAmount
     *
     * @return self
     */
    public function setWarningAmount(string $warningAmount): self
    {
        $this->warningAmount = $warningAmount;

        return $this;
    }

    /**
     * @param string $withdrawFee
     *
     * @return self
     */
    public function setWithdrawFee(string $withdrawFee): self
    {
        $this->withdrawFee = $withdrawFee;

        return $this;
    }

    /**
     * @param string $withdrawTheshold
     *
     * @return self
     */
    public function setWithdrawTheshold(string $withdrawTheshold): self
    {
        $this->withdrawTheshold = $withdrawTheshold;

        return $this;
    }

    /**
     * @return string
     */
    public function getAccountName(): ?string
    {
        return $this->accountName;
    }

    /**
     * @return string|null
     */
    public function getAssetId(): ?string
    {
        return $this->assetId;
    }

    /**
     * @return int|null
     */
    public function getCancelFlag(): ?int
    {
        return $this->cancelFlag;
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
     * @return int|null
     */
    public function getCoinSerialsId(): ?int
    {
        return $this->coinSerialsId;
    }

    /**
     * @return string|null
     */
    public function getContractAbi(): ?string
    {
        return $this->contractAbi;
    }

    /**
     * @return string|null
     */
    public function getContractAddress(): ?string
    {
        return $this->contractAddress;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * @return int|null
     */
    public function getDecimals(): ?int
    {
        return $this->decimals;
    }

    /**
     * @return string
     */
    public function getDisplayName(): ?string
    {
        return $this->displayName;
    }

    /**
     * @return string
     */
    public function getExplorerUrl(): ?string
    {
        return $this->explorerUrl;
    }

    /**
     * @return string
     */
    public function getExplorerUrlParameterAddress(): ?string
    {
        return $this->explorerUrlParameterAddress;
    }

    /**
     * @return string
     */
    public function getExplorerUrlParameterTx(): ?string
    {
        return $this->explorerUrlParameterTx;
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
    public function getIsMain(): ?int
    {
        return $this->isMain;
    }

    /**
     * @return string
     */
    public function getMaxWithdraw(): ?string
    {
        return $this->maxWithdraw;
    }

    /**
     * @return string
     */
    public function getMinDeposit(): ?string
    {
        return $this->minDeposit;
    }

    /**
     * @return string
     */
    public function getMinWithdraw(): ?string
    {
        return $this->minWithdraw;
    }

    /**
     * @return int
     */
    public function getPropertyId(): ?int
    {
        return $this->propertyId;
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    /**
     * @return string
     */
    public function getWarningAmount(): ?string
    {
        return $this->warningAmount;
    }

    /**
     * @return string
     */
    public function getWithdrawFee(): ?string
    {
        return $this->withdrawFee;
    }

    /**
     * @return string
     */
    public function getWithdrawTheshold(): ?string
    {
        return $this->withdrawTheshold;
    }

}
