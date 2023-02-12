<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 首页banner图片
 * Class ImgBanner
 *
 * @since 2.0
 *
 * @Entity(table="img_banner")
 */
class ImgBanner extends Model
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
     * 排序号
     *
     * @Column(name="sort_num", prop="sortNum")
     *
     * @var int
     */
    private $sortNum;

    /**
     * img路径
     *
     * @Column(name="img_src", prop="imgSrc")
     *
     * @var string|null
     */
    private $imgSrc;

    /**
     * 使用客户端，app, pc
     *
     * @Column(name="use_client", prop="useClient")
     *
     * @var string|null
     */
    private $useClient;

    /**
     * 内容类型，1-图片，2-视频
     *
     * @Column()
     *
     * @var int
     */
    private $type;

    /**
     * 场景类型:article=文章,product=产品,tripartite=三方
     *
     * @Column(name="scenes_type", prop="scenesType")
     *
     * @var string|null
     */
    private $scenesType;

    /**
     * 位置:index=首页,invite=邀请
     *
     * @Column()
     *
     * @var string|null
     */
    private $position;

    /**
     * 跳转链接
     *
     * @Column(name="link_href", prop="linkHref")
     *
     * @var string
     */
    private $linkHref;

    /**
     * 描述
     *
     * @Column()
     *
     * @var string|null
     */
    private $content;

    /**
     * 状态   1使用    0删除
     *
     * @Column()
     *
     * @var int
     */
    private $status;

    /**
     * 语言类型
     *
     * @Column(name="lang_type", prop="langType")
     *
     * @var string
     */
    private $langType;

    /**
     * 创建时间
     *
     * @Column(name="created_at", prop="createdAt")
     *
     * @var string
     */
    private $createdAt;

    /**
     * 更新时间
     *
     * @Column(name="updated_at", prop="updatedAt")
     *
     * @var string
     */
    private $updatedAt;


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
     * @param int $sortNum
     *
     * @return self
     */
    public function setSortNum(int $sortNum): self
    {
        $this->sortNum = $sortNum;

        return $this;
    }

    /**
     * @param string|null $imgSrc
     *
     * @return self
     */
    public function setImgSrc(?string $imgSrc): self
    {
        $this->imgSrc = $imgSrc;

        return $this;
    }

    /**
     * @param string|null $useClient
     *
     * @return self
     */
    public function setUseClient(?string $useClient): self
    {
        $this->useClient = $useClient;

        return $this;
    }

    /**
     * @param int $type
     *
     * @return self
     */
    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @param string|null $scenesType
     *
     * @return self
     */
    public function setScenesType(?string $scenesType): self
    {
        $this->scenesType = $scenesType;

        return $this;
    }

    /**
     * @param string|null $position
     *
     * @return self
     */
    public function setPosition(?string $position): self
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @param string $linkHref
     *
     * @return self
     */
    public function setLinkHref(string $linkHref): self
    {
        $this->linkHref = $linkHref;

        return $this;
    }

    /**
     * @param string|null $content
     *
     * @return self
     */
    public function setContent(?string $content): self
    {
        $this->content = $content;

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
     * @param string $langType
     *
     * @return self
     */
    public function setLangType(string $langType): self
    {
        $this->langType = $langType;

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
     * @return int
     */
    public function getId(): ?int
    
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getSortNum(): ?int
    
    {
        return $this->sortNum;
    }

    /**
     * @return string|null
     */
    public function getImgSrc(): ?string
    
    {
        return $this->imgSrc;
    }

    /**
     * @return string|null
     */
    public function getUseClient(): ?string
    
    {
        return $this->useClient;
    }

    /**
     * @return int
     */
    public function getType(): ?int
    
    {
        return $this->type;
    }

    /**
     * @return string|null
     */
    public function getScenesType(): ?string
    
    {
        return $this->scenesType;
    }

    /**
     * @return string|null
     */
    public function getPosition(): ?string
    
    {
        return $this->position;
    }

    /**
     * @return string
     */
    public function getLinkHref(): ?string
    
    {
        return $this->linkHref;
    }

    /**
     * @return string|null
     */
    public function getContent(): ?string
    
    {
        return $this->content;
    }

    /**
     * @return int
     */
    public function getStatus(): ?int
    
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getLangType(): ?string
    
    {
        return $this->langType;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): ?string
    
    {
        return $this->createdAt;
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): ?string
    
    {
        return $this->updatedAt;
    }


}
