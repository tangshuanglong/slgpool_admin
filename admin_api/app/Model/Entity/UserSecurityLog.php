<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 
 * Class UserSecurityLog
 *
 * @since 2.0
 *
 * @Entity(table="user_security_log")
 */
class UserSecurityLog extends Model
{
    /**
     * IP对应的地区
     *
     * @Column()
     *
     * @var string
     */
    private $address;

    /**
     * 创建时间
     *
     * @Column(name="create_time", prop="createTime")
     *
     * @var int
     */
    private $createTime;

    /**
     * 设备id， 如果是app,就是手机的imei
     *
     * @Column(name="device_id", prop="deviceId")
     *
     * @var string
     */
    private $deviceId;

    /**
     * 设备类型
     *
     * @Column(name="device_type", prop="deviceType")
     *
     * @var string
     */
    private $deviceType;

    /**
     * 错误类型，1-登录密码错误, 2-服务器异常
     *
     * @Column(name="fail_type", prop="failType")
     *
     * @var int
     */
    private $failType;

    /**
     * 用户安全类信息日志表
     * @Id()
     * @Column()
     *
     * @var int
     */
    private $id;

    /**
     * 客户端IP
     *
     * @Column()
     *
     * @var string
     */
    private $ip;

    /**
     * 状态，1-成功， 0-失败
     *
     * @Column()
     *
     * @var int
     */
    private $status;

    /**
     * 安全记录类型，如登出、登入、修改密码等的id，可暂时不用，留空
     *
     * @Column(name="type_id", prop="typeId")
     *
     * @var int|null
     */
    private $typeId;

    /**
     * 安全记录类型，如登出、登入、修改密码等
     *
     * @Column(name="type_name", prop="typeName")
     *
     * @var string
     */
    private $typeName;

    /**
     * 用户ID
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
     * @param string $deviceId
     *
     * @return self
     */
    public function setDeviceId(string $deviceId): self
    {
        $this->deviceId = $deviceId;

        return $this;
    }

    /**
     * @param string $deviceType
     *
     * @return self
     */
    public function setDeviceType(string $deviceType): self
    {
        $this->deviceType = $deviceType;

        return $this;
    }

    /**
     * @param int $failType
     *
     * @return self
     */
    public function setFailType(int $failType): self
    {
        $this->failType = $failType;

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
     * @param string $ip
     *
     * @return self
     */
    public function setIp(string $ip): self
    {
        $this->ip = $ip;

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
     * @param int|null $typeId
     *
     * @return self
     */
    public function setTypeId(?int $typeId): self
    {
        $this->typeId = $typeId;

        return $this;
    }

    /**
     * @param string $typeName
     *
     * @return self
     */
    public function setTypeName(string $typeName): self
    {
        $this->typeName = $typeName;

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
     * @return int
     */
    public function getCreateTime(): ?int
    {
        return $this->createTime;
    }

    /**
     * @return string
     */
    public function getDeviceId(): ?string
    {
        return $this->deviceId;
    }

    /**
     * @return string
     */
    public function getDeviceType(): ?string
    {
        return $this->deviceType;
    }

    /**
     * @return int
     */
    public function getFailType(): ?int
    {
        return $this->failType;
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
    public function getIp(): ?string
    {
        return $this->ip;
    }

    /**
     * @return int
     */
    public function getStatus(): ?int
    {
        return $this->status;
    }

    /**
     * @return int|null
     */
    public function getTypeId(): ?int
    {
        return $this->typeId;
    }

    /**
     * @return string
     */
    public function getTypeName(): ?string
    {
        return $this->typeName;
    }

    /**
     * @return int
     */
    public function getUid(): ?int
    {
        return $this->uid;
    }

}
