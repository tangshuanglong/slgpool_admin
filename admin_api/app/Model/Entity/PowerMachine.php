<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 矿机信息表
 * Class PowerMachine
 *
 * @since 2.0
 *
 * @Entity(table="power_machine")
 */
class PowerMachine extends Model
{
    /**
     * 算法 例如，sha256
     *
     * @Column()
     *
     * @var string
     */
    private $algorithm;

    /**
     * CPU
     *
     * @Column()
     *
     * @var string|null
     */
    private $cpu;

    /**
     * 创建时间
     *
     * @Column(name="created_at", prop="createdAt")
     *
     * @var string
     */
    private $createdAt;

    /**
     * 矿机描述
     *
     * @Column()
     *
     * @var string|null
     */
    private $description;

    /**
     * 显卡
     *
     * @Column(name="GPU", prop="gPU")
     *
     * @var string|null
     */
    private $gPU;

    /**
     * 额定算力 单位TH/s
     *
     * @Column(name="hash_rate", prop="hashRate")
     *
     * @var string
     */
    private $hashRate;

    /**
     * 自增ID
     * @Id()
     * @Column()
     *
     * @var int
     */
    private $id;

    /**
     * 矿机图片，json数据， 支持多张图片
     *
     * @Column()
     *
     * @var string
     */
    private $image;

    /**
     * 内存
     *
     * @Column()
     *
     * @var string|null
     */
    private $memory;

    /**
     * 主板
     *
     * @Column()
     *
     * @var string|null
     */
    private $motherboard;

    /**
     * 矿机名称
     *
     * @Column()
     *
     * @var string
     */
    private $name;

    /**
     * 噪音，单位 Bd
     *
     * @Column()
     *
     * @var int
     */
    private $noise;

    /**
     * 功率， 单位w
     *
     * @Column()
     *
     * @var int
     */
    private $power;

    /**
     * 外箱尺寸 单位 mm
     *
     * @Column()
     *
     * @var string
     */
    private $size;

    /**
     * 硬盘
     *
     * @Column()
     *
     * @var string|null
     */
    private $ssd;

    /**
     * 额定电压 单位V
     *
     * @Column()
     *
     * @var string
     */
    private $voltage;

    /**
     * 重量 单位 g
     *
     * @Column()
     *
     * @var int
     */
    private $weight;

    /**
     * 工作湿度 单位 %RH
     *
     * @Column(name="worker_hum", prop="workerHum")
     *
     * @var string
     */
    private $workerHum;

    /**
     * 工作温度，单位℃
     *
     * @Column(name="worker_temp", prop="workerTemp")
     *
     * @var string
     */
    private $workerTemp;


    /**
     * @param string $algorithm
     *
     * @return self
     */
    public function setAlgorithm(string $algorithm): self
    {
        $this->algorithm = $algorithm;

        return $this;
    }

    /**
     * @param string|null $cpu
     *
     * @return self
     */
    public function setCpu(?string $cpu): self
    {
        $this->cpu = $cpu;

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
     * @param string|null $description
     *
     * @return self
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @param string|null $gPU
     *
     * @return self
     */
    public function setGPU(?string $gPU): self
    {
        $this->gPU = $gPU;

        return $this;
    }

    /**
     * @param string $hashRate
     *
     * @return self
     */
    public function setHashRate(string $hashRate): self
    {
        $this->hashRate = $hashRate;

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
     * @param string $image
     *
     * @return self
     */
    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @param string|null $memory
     *
     * @return self
     */
    public function setMemory(?string $memory): self
    {
        $this->memory = $memory;

        return $this;
    }

    /**
     * @param string|null $motherboard
     *
     * @return self
     */
    public function setMotherboard(?string $motherboard): self
    {
        $this->motherboard = $motherboard;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param int $noise
     *
     * @return self
     */
    public function setNoise(int $noise): self
    {
        $this->noise = $noise;

        return $this;
    }

    /**
     * @param int $power
     *
     * @return self
     */
    public function setPower(int $power): self
    {
        $this->power = $power;

        return $this;
    }

    /**
     * @param string $size
     *
     * @return self
     */
    public function setSize(string $size): self
    {
        $this->size = $size;

        return $this;
    }

    /**
     * @param string|null $ssd
     *
     * @return self
     */
    public function setSsd(?string $ssd): self
    {
        $this->ssd = $ssd;

        return $this;
    }

    /**
     * @param string $voltage
     *
     * @return self
     */
    public function setVoltage(string $voltage): self
    {
        $this->voltage = $voltage;

        return $this;
    }

    /**
     * @param int $weight
     *
     * @return self
     */
    public function setWeight(int $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * @param string $workerHum
     *
     * @return self
     */
    public function setWorkerHum(string $workerHum): self
    {
        $this->workerHum = $workerHum;

        return $this;
    }

    /**
     * @param string $workerTemp
     *
     * @return self
     */
    public function setWorkerTemp(string $workerTemp): self
    {
        $this->workerTemp = $workerTemp;

        return $this;
    }

    /**
     * @return string
     */
    public function getAlgorithm(): ?string
    {
        return $this->algorithm;
    }

    /**
     * @return string|null
     */
    public function getCpu(): ?string
    {
        return $this->cpu;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return string|null
     */
    public function getGPU(): ?string
    {
        return $this->gPU;
    }

    /**
     * @return string
     */
    public function getHashRate(): ?string
    {
        return $this->hashRate;
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
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @return string|null
     */
    public function getMemory(): ?string
    {
        return $this->memory;
    }

    /**
     * @return string|null
     */
    public function getMotherboard(): ?string
    {
        return $this->motherboard;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getNoise(): ?int
    {
        return $this->noise;
    }

    /**
     * @return int
     */
    public function getPower(): ?int
    {
        return $this->power;
    }

    /**
     * @return string
     */
    public function getSize(): ?string
    {
        return $this->size;
    }

    /**
     * @return string|null
     */
    public function getSsd(): ?string
    {
        return $this->ssd;
    }

    /**
     * @return string
     */
    public function getVoltage(): ?string
    {
        return $this->voltage;
    }

    /**
     * @return int
     */
    public function getWeight(): ?int
    {
        return $this->weight;
    }

    /**
     * @return string
     */
    public function getWorkerHum(): ?string
    {
        return $this->workerHum;
    }

    /**
     * @return string
     */
    public function getWorkerTemp(): ?string
    {
        return $this->workerTemp;
    }

}
