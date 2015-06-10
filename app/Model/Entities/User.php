<?php
/**
 * Created by PhpStorm.
 * User: ondrej.votava
 * Date: 14. 9. 2014
 * Time: 19:54
 */

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
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected $password;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected $role;

    /**
     * @param string $username
     * @param string $password
     */
    function __construct($username, $password, $role = "admin")
    {

        $this->password = Passwords::hash($password);
        $this->username = $username;
    }


}