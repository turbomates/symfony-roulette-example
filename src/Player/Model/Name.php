<?php
declare(strict_types=1);

namespace Player\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable()
 */
final class Name
{
    /**
     * @ORM\Column(type="string", length=150, name="first_name")
     */
    private string $firstName;

    /**
     * @ORM\Column(type="string", length=150, name="last_name")
     */
    private string $lastName;

    public function __construct(string $firstName, string $lastName)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public function firstName(): string
    {
        return $this->firstName;
    }

    public function lastName(): string
    {
        return $this->lastName;
    }

    public function fullName(): string
    {
        return $this->firstName.' '.$this->lastName;
    }
}