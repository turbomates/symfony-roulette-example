<?php
/** @noinspection PhpFieldAssignmentTypeMismatchInspection */
declare(strict_types=1);

namespace Identity\Model;

use Doctrine\ORM\Mapping as ORM;
use Identity\Model\Event\Created;
use Lib\Model\AggregateRoot;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

/**
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="Identity\Infrastructure\Repository\UserRepository")
 */
class User extends AggregateRoot
{
    /**
     * @ORM\Id
     * @ORM\Column(type="guid")
     */
    private string $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private string $username;

    /**
     * @ORM\Embedded(class="Identity\Model\Password", columnPrefix=false)
     */
    private Password $password;

    private function __construct(string $id, string $username, Password $password)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
    }

    public static function create(string $id, string $name, Password $password): self
    {
        $user = new self($id, $name, $password);
        $user->addEvent(new Created($user->id, $user->username));

        return $user;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function authenticate(string $enteredPassword)
    {
        if (!$this->password->isValid($enteredPassword)) {
            throw new AuthenticationException("Invalid password");
        }
    }
}
