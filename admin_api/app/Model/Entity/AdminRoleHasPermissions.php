<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 
 * Class AdminRoleHasPermissions
 *
 * @since 2.0
 *
 * @Entity(table="admin_role_has_permissions")
 */
class AdminRoleHasPermissions extends Model
{
    /**
     * 菜单id
     * @Id(incrementing=false)
     * @Column(name="permission_id", prop="permissionId")
     *
     * @var int
     */
    private $permissionId;

    /**
     * 角色id
     *
     * @Column(name="role_id", prop="roleId")
     *
     * @var int
     */
    private $roleId;


    /**
     * @param int $permissionId
     *
     * @return self
     */
    public function setPermissionId(int $permissionId): self
    {
        $this->permissionId = $permissionId;

        return $this;
    }

    /**
     * @param int $roleId
     *
     * @return self
     */
    public function setRoleId(int $roleId): self
    {
        $this->roleId = $roleId;

        return $this;
    }

    /**
     * @return int
     */
    public function getPermissionId(): ?int
    {
        return $this->permissionId;
    }

    /**
     * @return int
     */
    public function getRoleId(): ?int
    {
        return $this->roleId;
    }

}
