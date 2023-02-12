<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 
 * Class WsPlatform
 *
 * @since 2.0
 *
 * @Entity(table="ws_platform")
 */
class WsPlatform extends Model
{
    /**
     * 数据类型。kline, depth
     *
     * @Column(name="data_type", prop="dataType")
     *
     * @var string
     */
    private $dataType;

    /**
     * 域名
     *
     * @Column(name="domain_name", prop="domainName")
     *
     * @var string
     */
    private $domainName;

    /**
     * ws连接信息
     * @Id()
     * @Column()
     *
     * @var int
     */
    private $id;

    /**
     * 是否是ssl协议， 1-是， 0-不是
     *
     * @Column(name="is_ssl", prop="isSsl")
     *
     * @var int
     */
    private $isSsl;

    /**
     * api的url
     *
     * @Column(name="kline_api_url", prop="klineApiUrl")
     *
     * @var string
     */
    private $klineApiUrl;

    /**
     * 路径, 如：/ws
     *
     * @Column()
     *
     * @var string
     */
    private $path;

    /**
     * k线周期
     *
     * @Column()
     *
     * @var string
     */
    private $period;

    /**
     * 平台
     *
     * @Column()
     *
     * @var string
     */
    private $platform;

    /**
     * 平台名称。中文
     *
     * @Column(name="platform_name_cn", prop="platformNameCn")
     *
     * @var string
     */
    private $platformNameCn;

    /**
     * 端口号
     *
     * @Column(name="port_number", prop="portNumber")
     *
     * @var int
     */
    private $portNumber;

    /**
     * 状态，0-关闭，1-开启
     *
     * @Column(name="status_flag", prop="statusFlag")
     *
     * @var int
     */
    private $statusFlag;

    /**
     * 类型，ext-币币，swap-永续合约, fut-交割合约，
     *
     * @Column()
     *
     * @var string
     */
    private $type;


    /**
     * @param string $dataType
     *
     * @return self
     */
    public function setDataType(string $dataType): self
    {
        $this->dataType = $dataType;

        return $this;
    }

    /**
     * @param string $domainName
     *
     * @return self
     */
    public function setDomainName(string $domainName): self
    {
        $this->domainName = $domainName;

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
     * @param int $isSsl
     *
     * @return self
     */
    public function setIsSsl(int $isSsl): self
    {
        $this->isSsl = $isSsl;

        return $this;
    }

    /**
     * @param string $klineApiUrl
     *
     * @return self
     */
    public function setKlineApiUrl(string $klineApiUrl): self
    {
        $this->klineApiUrl = $klineApiUrl;

        return $this;
    }

    /**
     * @param string $path
     *
     * @return self
     */
    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @param string $period
     *
     * @return self
     */
    public function setPeriod(string $period): self
    {
        $this->period = $period;

        return $this;
    }

    /**
     * @param string $platform
     *
     * @return self
     */
    public function setPlatform(string $platform): self
    {
        $this->platform = $platform;

        return $this;
    }

    /**
     * @param string $platformNameCn
     *
     * @return self
     */
    public function setPlatformNameCn(string $platformNameCn): self
    {
        $this->platformNameCn = $platformNameCn;

        return $this;
    }

    /**
     * @param int $portNumber
     *
     * @return self
     */
    public function setPortNumber(int $portNumber): self
    {
        $this->portNumber = $portNumber;

        return $this;
    }

    /**
     * @param int $statusFlag
     *
     * @return self
     */
    public function setStatusFlag(int $statusFlag): self
    {
        $this->statusFlag = $statusFlag;

        return $this;
    }

    /**
     * @param string $type
     *
     * @return self
     */
    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getDataType(): ?string
    {
        return $this->dataType;
    }

    /**
     * @return string
     */
    public function getDomainName(): ?string
    {
        return $this->domainName;
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
    public function getIsSsl(): ?int
    {
        return $this->isSsl;
    }

    /**
     * @return string
     */
    public function getKlineApiUrl(): ?string
    {
        return $this->klineApiUrl;
    }

    /**
     * @return string
     */
    public function getPath(): ?string
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getPeriod(): ?string
    {
        return $this->period;
    }

    /**
     * @return string
     */
    public function getPlatform(): ?string
    {
        return $this->platform;
    }

    /**
     * @return string
     */
    public function getPlatformNameCn(): ?string
    {
        return $this->platformNameCn;
    }

    /**
     * @return int
     */
    public function getPortNumber(): ?int
    {
        return $this->portNumber;
    }

    /**
     * @return int
     */
    public function getStatusFlag(): ?int
    {
        return $this->statusFlag;
    }

    /**
     * @return string
     */
    public function getType(): ?string
    {
        return $this->type;
    }

}
