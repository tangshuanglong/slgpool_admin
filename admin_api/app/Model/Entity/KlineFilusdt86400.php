<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 各平台的k线数据
 * Class KlineFilusdt86400
 *
 * @since 2.0
 *
 * @Entity(table="kline_filusdt_86400")
 */
class KlineFilusdt86400 extends Model
{
    /**
     * 成交量
     *
     * @Column()
     *
     * @var string
     */
    private $amount;

    /**
     * 收盘价
     *
     * @Column(name="close_price", prop="closePrice")
     *
     * @var string
     */
    private $closePrice;

    /**
     * 分组id
     *
     * @Column(name="group_id", prop="groupId")
     *
     * @var int
     */
    private $groupId;

    /**
     * 最高价
     *
     * @Column(name="high_price", prop="highPrice")
     *
     * @var string
     */
    private $highPrice;

    /**
     * 
     * @Id()
     * @Column()
     *
     * @var int
     */
    private $id;

    /**
     * 最低价
     *
     * @Column(name="low_price", prop="lowPrice")
     *
     * @var string
     */
    private $lowPrice;

    /**
     * 开盘价
     *
     * @Column(name="open_price", prop="openPrice")
     *
     * @var string
     */
    private $openPrice;

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
     * 交易对，格式如：btc/usd
     *
     * @Column()
     *
     * @var string
     */
    private $symbol;

    /**
     * 成交额
     *
     * @Column()
     *
     * @var string
     */
    private $volume;


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
     * @param string $closePrice
     *
     * @return self
     */
    public function setClosePrice(string $closePrice): self
    {
        $this->closePrice = $closePrice;

        return $this;
    }

    /**
     * @param int $groupId
     *
     * @return self
     */
    public function setGroupId(int $groupId): self
    {
        $this->groupId = $groupId;

        return $this;
    }

    /**
     * @param string $highPrice
     *
     * @return self
     */
    public function setHighPrice(string $highPrice): self
    {
        $this->highPrice = $highPrice;

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
     * @param string $lowPrice
     *
     * @return self
     */
    public function setLowPrice(string $lowPrice): self
    {
        $this->lowPrice = $lowPrice;

        return $this;
    }

    /**
     * @param string $openPrice
     *
     * @return self
     */
    public function setOpenPrice(string $openPrice): self
    {
        $this->openPrice = $openPrice;

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
     * @param string $symbol
     *
     * @return self
     */
    public function setSymbol(string $symbol): self
    {
        $this->symbol = $symbol;

        return $this;
    }

    /**
     * @param string $volume
     *
     * @return self
     */
    public function setVolume(string $volume): self
    {
        $this->volume = $volume;

        return $this;
    }

    /**
     * @return string
     */
    public function getAmount(): ?string
    {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function getClosePrice(): ?string
    {
        return $this->closePrice;
    }

    /**
     * @return int
     */
    public function getGroupId(): ?int
    {
        return $this->groupId;
    }

    /**
     * @return string
     */
    public function getHighPrice(): ?string
    {
        return $this->highPrice;
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
    public function getLowPrice(): ?string
    {
        return $this->lowPrice;
    }

    /**
     * @return string
     */
    public function getOpenPrice(): ?string
    {
        return $this->openPrice;
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
    public function getSymbol(): ?string
    {
        return $this->symbol;
    }

    /**
     * @return string
     */
    public function getVolume(): ?string
    {
        return $this->volume;
    }

}
