<?php

namespace App\Model\Entities;

use Doctrine\ORM\Mapping AS ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Kdyby\Doctrine\Entities\BaseEntity;
use Kdyby\Doctrine\Entities\Attributes\Identifier;
use Nette\Security\Passwords;


/**
 * Class User
 * @package App\Model\Entities
 * @author Ondra Votava <ja@ondravotava.cz>
 */

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */

class User extends BaseEntity
{

    use Identifier;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected $username;

    /**
     * @ORM\Column(type="string", nullable=false, unique=true)
     * @var string
     */
    private $password;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    private $role;

    /**
     * @var array roleList
     */
    static private $roleList = array(
        'admin' => 'admin',
        'moderator' => 'moderator',
        'quest' => 'quest');

    /**
     * @param string $username
     * @param string $password
     */
    function __construct($username, $password, $role = "quest")
    {

        $this->username = $username;
        $this->setPassword($password);
        $this->setRole($role);

    }

    public function setRole($role)
    {
        if(in_array($role, self::$roleList))
            $this->role = $role;
    }

    public function getRole()
    {
        return $this->role;
    }

    /**
     * @return array $roleList
     */
    public static function getRoleList()
    {
        return self::$roleList;
    }

    /**
     * @param $password
     */
    public function setPassword($password)
    {

        $this->password = Passwords::hash($password);

    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }
}