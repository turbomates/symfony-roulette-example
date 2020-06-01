<?php
declare(strict_types=1);

namespace Player\Application\Registration;

use Symfony\Component\Validator\Constraints as Assert;

class Register
{
    /**
     * @Assert\NotNull()
     * @Assert\NotBlank
     * TODO: Unique validation
     */
    public string $username;
    /**
     * @Assert\NotNull()
     * @Assert\NotBlank
     */
    public string $firstName;
    /**
     * @Assert\NotNull()
     * @Assert\NotBlank
     */
    public string $lastName;
    /**
     * @Assert\NotNull()
     * @Assert\Length(min = 1, max = 30, minMessage="Min passsword is 1", maxMessage="Max password is 30")
     */
    public string $password;
}