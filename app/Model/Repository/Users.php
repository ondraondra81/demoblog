<?php
/**
 * Created by PhpStorm.
 * User: ondrej.votava
 * Date: 1. 9. 2014
 * Time: 16:26
 */

namespace App\Model\Repository;
use Nette;
use Kdyby;
use App\Model;

class Users extends Nette\Object
{


    private $em;
    private $repository;

    public function __construct(Kdyby\Doctrine\EntityManager $entityManager)
    {
        $this->em = $entityManager;
        $this->repository = $entityManager->getRepository(Model\Entities\User::class);
    }

    /**
     * @param $username
     *
     * @return mixed|null|object
     */
    public function findByUsername($username)
    {
        return $this->repository->findOneBy(array('username' => $username));
    }


} 