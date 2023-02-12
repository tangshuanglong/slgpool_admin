<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 
 * Class WalletPayMethod
 *
 * @since 2.0
 *
 * @Entity(table="wallet_pay_method")
 */
class WalletPayMethod extends Model
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
     * 
     *
     * @Column(name="account_number", prop="accountNumber")
     *
     * @var string|null
     */
    private $accountNumber;

    /**
     * 
     *
     * @Column(name="account_name", prop="accountName")
     *
     * @var string|null
     */
    private $accountName;

    /**
     * 
     *
     * @Column(name="pay_name", prop="payName")
     *
     * @var string|null
     */
    private $payName;

    /**
     * 银行名称
     *
     * @Column(name="bank_name", prop="bankName")
     *
     * @var string
     */
    private $bankName;

    /**
     * 
     *
     * @Column(name="pay_type", prop="payType")
     *
     * @var int
     */
    private $payType;


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
     * @param string|null $accountNumber
     *
     * @return self
     */
    public function setAccountNumber(?string $accountNumber): self
    {
        $this->accountNumber = $accountNumber;

        return $this;
    }

    /**
     * @param string|null $accountName
     *
     * @return self
     */
    public function setAccountName(?string $accountName): self
    {
        $this->accountName = $accountName;

        return $this;
    }

    /**
     * @param string|null $payName
     *
     * @return self
     */
    public function setPayName(?string $payName): self
    {
        $this->payName = $payName;

        return $this;
    }

    /**
     * @param string $bankName
     *
     * @return self
     */
    public function setBankName(string $bankName): self
    {
        $this->bankName = $bankName;

        return $this;
    }

    /**
     * @param int $payType
     *
     * @return self
     */
    public function setPayType(int $payType): self
    {
        $this->payType = $payType;

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
     * @return string|null
     */
    public function getAccountNumber(): ?string
    {
        return $this->accountNumber;
    }

    /**
     * @return string|null
     */
    public function getAccountName(): ?string
    {
        return $this->accountName;
    }

    /**
     * @return string|null
     */
    public function getPayName(): ?string
    {
        return $this->payName;
    }

    /**
     * @return string
     */
    public function getBankName(): ?string
    {
        return $this->bankName;
    }

    /**
     * @return int
     */
    public function getPayType(): ?int
    {
        return $this->payType;
    }

}
