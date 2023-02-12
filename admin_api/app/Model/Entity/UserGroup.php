<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 
 * Class UserGroup
 *
 * @since 2.0
 *
 * @Entity(table="user_group")
 */
class UserGroup extends Model
{
    /**
     * 组id
     *
     * @Column(name="group_id", prop="groupId")
     *
     * @var int
     */
    private $groupId;

    /**
     * 中文组名
     *
     * @Column(name="group_name_cn", prop="groupNameCn")
     *
     * @var string|null
     */
    private $groupNameCn;

    /**
     * 英文组名
     *
     * @Column(name="group_name_en", prop="groupNameEn")
     *
     * @var string|null
     */
    private $groupNameEn;

    /**
     * 组名缩写
     *
     * @Column(name="group_name_short", prop="groupNameShort")
     *
     * @var string
     */
    private $groupNameShort;

    /**
     * 用户组
     * @Id()
     * @Column()
     *
     * @var int
     */
    private $id;


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
     * @param string|null $groupNameCn
     *
     * @return self
     */
    public function setGroupNameCn(?string $groupNameCn): self
    {
        $this->groupNameCn = $groupNameCn;

        return $this;
    }

    /**
     * @param string|null $groupNameEn
     *
     * @return self
     */
    public function setGroupNameEn(?string $groupNameEn): self
    {
        $this->groupNameEn = $groupNameEn;

        return $this;
    }

    /**
     * @param string $groupNameShort
     *
     * @return self
     */
    public function setGroupNameShort(string $groupNameShort): self
    {
        $this->groupNameShort = $groupNameShort;

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
     * @return int
     */
    public function getGroupId(): ?int
    {
        return $this->groupId;
    }

    /**
     * @return string|null
     */
    public function getGroupNameCn(): ?string
    {
        return $this->groupNameCn;
    }

    /**
     * @return string|null
     */
    public function getGroupNameEn(): ?string
    {
        return $this->groupNameEn;
    }

    /**
     * @return string
     */
    public function getGroupNameShort(): ?string
    {
        return $this->groupNameShort;
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

}
