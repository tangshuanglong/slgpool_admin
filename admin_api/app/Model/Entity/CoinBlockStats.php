<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 
 * Class CoinBlockStats
 *
 * @since 2.0
 *
 * @Entity(table="coin_block_stats")
 */
class CoinBlockStats extends Model
{
    /**
     * 区块奖励
     *
     * @Column(name="block_reward", prop="blockReward")
     *
     * @var string
     */
    private $blockReward;

    /**
     * 区块时间
     *
     * @Column(name="block_time", prop="blockTime")
     *
     * @var int
     */
    private $blockTime;

    /**
     * 币种类型
     *
     * @Column(name="coin_type", prop="coinType")
     *
     * @var string
     */
    private $coinType;

    /**
     * 当前挖矿难度
     *
     * @Column()
     *
     * @var string
     */
    private $difficulty;

    /**
     * 自增ID
     * @Id()
     * @Column()
     *
     * @var int
     */
    private $id;

    /**
     * 当前区块高度
     *
     * @Column(name="last_block", prop="lastBlock")
     *
     * @var int
     */
    private $lastBlock;

    /**
     * 全网算力
     *
     * @Column(name="net_hash", prop="netHash")
     *
     * @var string
     */
    private $netHash;

    /**
     * 最近三天的全网算力
     *
     * @Column(name="net_hash_half_week", prop="netHashHalfWeek")
     *
     * @var string
     */
    private $netHashHalfWeek;

    /**
     * 最近一周的全网算力
     *
     * @Column(name="net_hash_one_week", prop="netHashOneWeek")
     *
     * @var string
     */
    private $netHashOneWeek;

    /**
     * 预计下次挖矿难度
     *
     * @Column(name="next_difficulty", prop="nextDifficulty")
     *
     * @var string|null
     */
    private $nextDifficulty;

    /**
     * 下次区块更新时间
     *
     * @Column(name="next_difficulty_time", prop="nextDifficultyTime")
     *
     * @var int|null
     */
    private $nextDifficultyTime;

    /**
     * 记录更新时间
     *
     * @Column(name="updated_at", prop="updatedAt")
     *
     * @var string
     */
    private $updatedAt;


    /**
     * @param string $blockReward
     *
     * @return self
     */
    public function setBlockReward(string $blockReward): self
    {
        $this->blockReward = $blockReward;

        return $this;
    }

    /**
     * @param int $blockTime
     *
     * @return self
     */
    public function setBlockTime(int $blockTime): self
    {
        $this->blockTime = $blockTime;

        return $this;
    }

    /**
     * @param string $coinType
     *
     * @return self
     */
    public function setCoinType(string $coinType): self
    {
        $this->coinType = $coinType;

        return $this;
    }

    /**
     * @param string $difficulty
     *
     * @return self
     */
    public function setDifficulty(string $difficulty): self
    {
        $this->difficulty = $difficulty;

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
     * @param int $lastBlock
     *
     * @return self
     */
    public function setLastBlock(int $lastBlock): self
    {
        $this->lastBlock = $lastBlock;

        return $this;
    }

    /**
     * @param string $netHash
     *
     * @return self
     */
    public function setNetHash(string $netHash): self
    {
        $this->netHash = $netHash;

        return $this;
    }

    /**
     * @param string $netHashHalfWeek
     *
     * @return self
     */
    public function setNetHashHalfWeek(string $netHashHalfWeek): self
    {
        $this->netHashHalfWeek = $netHashHalfWeek;

        return $this;
    }

    /**
     * @param string $netHashOneWeek
     *
     * @return self
     */
    public function setNetHashOneWeek(string $netHashOneWeek): self
    {
        $this->netHashOneWeek = $netHashOneWeek;

        return $this;
    }

    /**
     * @param string|null $nextDifficulty
     *
     * @return self
     */
    public function setNextDifficulty(?string $nextDifficulty): self
    {
        $this->nextDifficulty = $nextDifficulty;

        return $this;
    }

    /**
     * @param int|null $nextDifficultyTime
     *
     * @return self
     */
    public function setNextDifficultyTime(?int $nextDifficultyTime): self
    {
        $this->nextDifficultyTime = $nextDifficultyTime;

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
     * @return string
     */
    public function getBlockReward(): ?string
    {
        return $this->blockReward;
    }

    /**
     * @return int
     */
    public function getBlockTime(): ?int
    {
        return $this->blockTime;
    }

    /**
     * @return string
     */
    public function getCoinType(): ?string
    {
        return $this->coinType;
    }

    /**
     * @return string
     */
    public function getDifficulty(): ?string
    {
        return $this->difficulty;
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
    public function getLastBlock(): ?int
    {
        return $this->lastBlock;
    }

    /**
     * @return string
     */
    public function getNetHash(): ?string
    {
        return $this->netHash;
    }

    /**
     * @return string
     */
    public function getNetHashHalfWeek(): ?string
    {
        return $this->netHashHalfWeek;
    }

    /**
     * @return string
     */
    public function getNetHashOneWeek(): ?string
    {
        return $this->netHashOneWeek;
    }

    /**
     * @return string|null
     */
    public function getNextDifficulty(): ?string
    {
        return $this->nextDifficulty;
    }

    /**
     * @return int|null
     */
    public function getNextDifficultyTime(): ?int
    {
        return $this->nextDifficultyTime;
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

}
