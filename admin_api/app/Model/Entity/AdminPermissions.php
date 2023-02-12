<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 
 * Class AdminPermissions
 *
 * @since 2.0
 *
 * @Entity(table="admin_permissions")
 */
class AdminPermissions extends Model
{
    /**
     * 能否删除，0-可以，1-不可以
     *
     * @Column(name="cannot_delete", prop="cannotDelete")
     *
     * @var int
     */
    private $cannotDelete;

    /**
     * 
     *
     * @Column(name="created_at", prop="createdAt")
     *
     * @var string|null
     */
    private $createdAt;

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
     * @Column()
     *
     * @var string
     */
    private $name;

    /**
     * 具体权限中文名
     *
     * @Column(name="name_action_cn", prop="nameActionCn")
     *
     * @var string|null
     */
    private $nameActionCn;

    /**
     * 权限模块分类
     *
     * @Column(name="name_group", prop="nameGroup")
     *
     * @var string
     */
    private $nameGroup;

    /**
     * 权限模块分类中文名称
     *
     * @Column(name="name_group_cn", prop="nameGroupCn")
     *
     * @var string|null
     */
    private $nameGroupCn;

    /**
     * 权限对应的uri
     *
     * @Column(name="permission_uri", prop="permissionUri")
     *
     * @var string
     */
    private $permissionUri;

    /**
     * 
     *
     * @Column(name="updated_at", prop="updatedAt")
     *
     * @var string|null
     */
    private $updatedAt;


    /**
     * @param int $cannotDelete
     *
     * @return self
     */
    public function setCannotDelete(int $cannotDelete): self
    {
        $this->cannotDelete = $cannotDelete;

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
     * @param string|null $nameActionCn
     *
     * @return self
     */
    public function setNameActionCn(?string $nameActionCn): self
    {
        $this->nameActionCn = $nameActionCn;

        return $this;
    }

    /**
     * @param string $nameGroup
     *
     * @return self
     */
    public function setNameGroup(string $nameGroup): self
    {
        $this->nameGroup = $nameGroup;

        return $this;
    }

    /**
     * @param string|null $nameGroupCn
     *
     * @return self
     */
    public function setNameGroupCn(?string $nameGroupCn): self
    {
        $this->nameGroupCn = $nameGroupCn;

        return $this;
    }

    /**
     * @param string $permissionUri
     *
     * @return self
     */
    public function setPermissionUri(string $permissionUri): self
    {
        $this->permissionUri = $permissionUri;

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
    public function getCannotDelete(): ?int
    {
        return $this->cannotDelete;
    }

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
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
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getNameActionCn(): ?string
    {
        return $this->nameActionCn;
    }

    /**
     * @return string
     */
    public function getNameGroup(): ?string
    {
        return $this->nameGroup;
    }

    /**
     * @return string|null
     */
    public function getNameGroupCn(): ?string
    {
        return $this->nameGroupCn;
    }

    /**
     * @return string
     */
    public function getPermissionUri(): ?string
    {
        return $this->permissionUri;
    }

    /**
     * @return string|null
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

}
