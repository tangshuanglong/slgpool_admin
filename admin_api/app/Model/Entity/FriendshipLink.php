<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 
 * Class FriendshipLink
 *
 * @since 2.0
 *
 * @Entity(table="friendship_link")
 */
class FriendshipLink extends Model
{
    /**
     * 添加时间
     *
     * @Column()
     *
     * @var int
     */
    private $addtime;

    /**
     * 友情链接表
     * @Id()
     * @Column()
     *
     * @var int
     */
    private $id;

    /**
     * 图片路径
     *
     * @Column()
     *
     * @var string
     */
    private $img;

    /**
     * 名称
     *
     * @Column()
     *
     * @var string
     */
    private $name;

    /**
     * 跳转路径
     *
     * @Column()
     *
     * @var string
     */
    private $url;


    /**
     * @param int $addtime
     *
     * @return self
     */
    public function setAddtime(int $addtime): self
    {
        $this->addtime = $addtime;

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
     * @param string $img
     *
     * @return self
     */
    public function setImg(string $img): self
    {
        $this->img = $img;

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
     * @param string $url
     *
     * @return self
     */
    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return int
     */
    public function getAddtime(): ?int
    {
        return $this->addtime;
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
    public function getImg(): ?string
    {
        return $this->img;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

}
