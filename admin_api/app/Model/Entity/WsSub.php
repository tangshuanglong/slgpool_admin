<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 
 * Class WsSub
 *
 * @since 2.0
 *
 * @Entity(table="ws_sub")
 */
class WsSub extends Model
{
    /**
     * ws关联表
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
     * @var string
     */
    private $platformId;

    /**
     * 订阅信息
     *
     * @Column(name="sub_info", prop="subInfo")
     *
     * @var string
     */
    private $subInfo;

    /**
     * 标记
     *
     * @Column()
     *
     * @var string
     */
    private $symbol;


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
     * @param string $platformId
     *
     * @return self
     */
    public function setPlatformId(string $platformId): self
    {
        $this->platformId = $platformId;

        return $this;
    }

    /**
     * @param string $subInfo
     *
     * @return self
     */
    public function setSubInfo(string $subInfo): self
    {
        $this->subInfo = $subInfo;

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
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getPlatformId(): ?string
    {
        return $this->platformId;
    }

    /**
     * @return string
     */
    public function getSubInfo(): ?string
    {
        return $this->subInfo;
    }

    /**
     * @return string
     */
    public function getSymbol(): ?string
    {
        return $this->symbol;
    }

}
