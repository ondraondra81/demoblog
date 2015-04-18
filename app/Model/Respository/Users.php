<?php
/**
 * Created by PhpStorm.
 * User: ondrej.votava
 * Date: 16. 4. 2015
 * Time: 10:55
 */

namespace App\Model\Repository;

use App\Model\Entities;
use Nette;
use Kdyby;

/**
 * Class Users
 * @package App\Model\Repository
 * @author Ondra Votava <ja@ondravotava.cz>
 */

class Users extends Nette\Object
{

    /**
     * @var Kdyby\Doctrine\EntityManager
     */
    private $em;

    private $repository;



    public function __construct(Kdyby\Doctrine\EntityManager $entityManager)
    {
        $this->em = $entityManager;
        $this->repository = $entityManager->getRepository(Entities\User::class);
    }

    /**
     * @param $username
     *
     * @return null|Entities\User
     */
    public function findByUsername($username)
    {
        return $this->repository->findOneBy(array('username' => $username));
    }

    /**
     * @param $id
     *
     * @return mixed|null|object
     */
    public function findById($id)
    {

        return $this->repository->findOneBy(array('id' => $id));
    }
}