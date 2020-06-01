<?php
declare(strict_types=1);

namespace Identity\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable()
 */
class Password
{
    /**
     * @ORM\Column(type="string", length=150)
     */
    private string $password;

    private function __construct(string $password)
    {
        $this->password = $password;
    }

    public static function createEncoded(string $raw): self
    {
        return new self(self::encode($raw));
    }

    public function change(string $newRaw)
    {
        $this->password = self::encode($newRaw);
    }

    public function isValid(string $enteredPassword): bool
    {
        return password_verify($enteredPassword, $this->password);
    }

    private static function encode(string $raw): string
    {
        return password_hash($raw, PASSWORD_DEFAULT);
    }
}