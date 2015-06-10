<?php
/**
 * Created by PhpStorm.
 * User: ondrej.votava
 * Date: 16. 4. 2015
 * Time: 11:23
 */

namespace App\Model;

use Nette;
use Nette\Security as NS;
use Kdyby;

/**
 * Class Authenticator
 * @package App\Model
 * @author  Ondra Votava <ja@ondravotava.cz>
 */
class Authenticator extends Nette\Object implements NS\IAuthenticator
{

    /**
     * @var Repository\Users users
     */
    private $users;


    public function __construct(Repository\Users $users)
    {
        $this->users = $users;
    }


    /**
     * @param array $credentials
     *
     * @return NS\Identity
     * @throws NS\AuthenticationException
     */
    public function authenticate(array $credentials)
    {

        list($username, $password) = $credentials;

        /**
         * @var Entities\User $user
         */
        $user = $this->users->findByUsername($username);

        # nenalezli jsem uživatele
        if (!$user) {
            throw new NS\AuthenticationException("Uživatel '$username' nenalezen.", self::IDENTITY_NOT_FOUND);
        }

        #nesedí hesla
        if (!NS\Passwords::verify($password,$user->getPassword())) {
            throw new NS\AuthenticationException("Neplatné heslo.", self::INVALID_CREDENTIAL);
        }

        # vrátíme identitu
        return new NS\Identity($user->getId(), $user->getRole(), array(
            'username' => $user->username
        ));
    }


}
