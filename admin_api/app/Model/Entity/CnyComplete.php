<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 各平台的k线数据
 * Class CnyComplete
 *
 * @since 2.0
 *
 * @Entity(table="cny_complete")
 */
class CnyComplete extends Model
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
     * 平台id
     *
     * @Column(name="platform_id", prop="platformId")
     *
     * @var int
     */
    private $platformId;

    /**
     * 分组时间段
     *
     * @Column(name="sort_time", prop="sortTime")
     *
     * @var int
     */
    private $sortTime;

    /**
     * usd 价格
     *
     * @Column(name="usd_price", prop="usdPrice")
     *
     * @var string
     */
    private $usdPrice;

    /**
     * usdt 价格
     *
     * @Column(name="usdt_price", prop="usdtPrice")
     *
     * @var string
     */
    private $usdtPrice;


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
     * @param int $platformId
     *
     * @return self
     */
    public function setPlatformId(int $platformId): self
    {
        $this->platformId = $platformId;

        return $this;
    }

    /**
     * @param int $sortTime
     *
     * @return self
     */
    public function setSortTime(int $sortTime): self
    {
        $this->sortTime = $sortTime;

        return $this;
    }

    /**
     * @param string $usdPrice
     *
     * @return self
     */
    public function setUsdPrice(string $usdPrice): self
    {
        $this->usdPrice = $usdPrice;

        return $this;
    }

    /**
     * @param string $usdtPrice
     *
     * @return self
     */
    public function setUsdtPrice(string $usdtPrice): self
    {
        $this->usdtPrice = $usdtPrice;

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
    public function getPlatformId(): ?int
    {
        return $this->platformId;
    }

    /**
     * @return int
     */
    public function getSortTime(): ?int
    {
        return $this->sortTime;
    }

    /**
     * @return string
     */
    public function getUsdPrice(): ?string
    {
        return $this->usdPrice;
    }

    /**
     * @return string
     */
    public function getUsdtPrice(): ?string
    {
        return $this->usdtPrice;
    }

}
