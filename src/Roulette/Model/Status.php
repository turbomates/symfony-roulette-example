<?php
declare(strict_types=1);

namespace Roulette\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable()
 */
class Status
{
    const ACTIVE = 'active';
    const FINISHED = 'finished';

    /**
     * @ORM\Column(name="status", type="string", length=20)
     */
    protected $status;

    /**
     * @param string $status
     */
    private function __construct(string $status)
    {
        if (!in_array($status, self::getStatuses(), true)) throw new \LogicException('Unknown status');
        $this->status = $status;
    }

    public static function active(): self
    {
        return new self(self::ACTIVE);
    }

    public function finish()
    {
        if (!$this->isActive()) throw new \LogicException('Cant finish');
        $this->status = self::FINISHED;
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->status === self::ACTIVE;
    }

    /**
     * @return array
     */
    public static function getStatuses()
    {
        return [
            self::ACTIVE,
            self::FINISHED,
        ];
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->status;
    }
}