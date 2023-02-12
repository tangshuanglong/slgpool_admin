<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 文章表(新闻、活动、公告、推送文章、其他）
 * Class Article
 *
 * @since 2.0
 *
 * @Entity(table="article")
 */
class Article extends Model
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
     * 标题
     *
     * @Column()
     *
     * @var string
     */
    private $title;

    /**
     * 缩略图
     *
     * @Column()
     *
     * @var string|null
     */
    private $thumbnail;

    /**
     * 简介
     *
     * @Column()
     *
     * @var string|null
     */
    private $summary;

    /**
     * 内容
     *
     * @Column()
     *
     * @var string
     */
    private $content;

    /**
     * 文章类型
     *
     * @Column()
     *
     * @var string
     */
    private $type;

    /**
     * 创建人ID
     *
     * @Column(name="assign_to", prop="assignTo")
     *
     * @var int
     */
    private $assignTo;

    /**
     * 是否已推送 0-未推送 1-已推送
     *
     * @Column(name="is_pushed", prop="isPushed")
     *
     * @var int|null
     */
    private $isPushed;

    /**
     * 状态。0-下架 1-上架
     *
     * @Column()
     *
     * @var int
     */
    private $status;

    /**
     * 排序
     *
     * @Column(name="order_num", prop="orderNum")
     *
     * @var int
     */
    private $orderNum;

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
     * @var string|null
     */
    private $createdAt;

    /**
     * 更新时间
     *
     * @Column(name="updated_at", prop="updatedAt")
     *
     * @var string|null
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
     * @param string $title
     *
     * @return self
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @param string|null $thumbnail
     *
     * @return self
     */
    public function setThumbnail(?string $thumbnail): self
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    /**
     * @param string|null $summary
     *
     * @return self
     */
    public function setSummary(?string $summary): self
    {
        $this->summary = $summary;

        return $this;
    }

    /**
     * @param string $content
     *
     * @return self
     */
    public function setContent(string $content): self
    {
        $this->content = $content;

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
     * @param int $assignTo
     *
     * @return self
     */
    public function setAssignTo(int $assignTo): self
    {
        $this->assignTo = $assignTo;

        return $this;
    }

    /**
     * @param int|null $isPushed
     *
     * @return self
     */
    public function setIsPushed(?int $isPushed): self
    {
        $this->isPushed = $isPushed;

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
     * @param int $orderNum
     *
     * @return self
     */
    public function setOrderNum(int $orderNum): self
    {
        $this->orderNum = $orderNum;

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
     * @param string|null $createdAt
     *
     * @return self
     */
    public function setCreatedAt(?string $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @param string|null $updatedAt
     *
     * @return self
     */
    public function setUpdatedAt(?string $updatedAt): self
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
     * @return string
     */
    public function getTitle(): ?string
    
    {
        return $this->title;
    }

    /**
     * @return string|null
     */
    public function getThumbnail(): ?string
    
    {
        return $this->thumbnail;
    }

    /**
     * @return string|null
     */
    public function getSummary(): ?string
    
    {
        return $this->summary;
    }

    /**
     * @return string
     */
    public function getContent(): ?string
    
    {
        return $this->content;
    }

    /**
     * @return string
     */
    public function getType(): ?string
    
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getAssignTo(): ?int
    
    {
        return $this->assignTo;
    }

    /**
     * @return int|null
     */
    public function getIsPushed(): ?int
    
    {
        return $this->isPushed;
    }

    /**
     * @return int
     */
    public function getStatus(): ?int
    
    {
        return $this->status;
    }

    /**
     * @return int
     */
    public function getOrderNum(): ?int
    
    {
        return $this->orderNum;
    }

    /**
     * @return string
     */
    public function getLangType(): ?string
    
    {
        return $this->langType;
    }

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string
    
    {
        return $this->createdAt;
    }

    /**
     * @return string|null
     */
    public function getUpdatedAt(): ?string
    
    {
        return $this->updatedAt;
    }


}
