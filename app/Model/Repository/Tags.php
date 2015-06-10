<?php
/**
 * Created by PhpStorm.
 * User: ondrej.votava
 * Date: 19. 3. 2015
 * Time: 10:24
 */

namespace App\Model\Repository;

use Kdyby;
use Kdyby\Doctrine\EntityRepository;
use Nette;
use App\Model\Entities;
/**
 * Class Tags
 * @package App\Model\Dao
 * @author Ondra Votava <ja@ondravotava.cz>
 */

class Tags extends Nette\Object
{


    private $em;
    /**
     * @var  EntityRepository $repository
     */
    private $repository;

    /**
     * @param Kdyby\Doctrine\EntityManager $entityManager
     */
    public function __construct(Kdyby\Doctrine\EntityManager $entityManager)
    {
        $this->em = $entityManager;
        $this->repository = $this->em->getRepository(Entities\Tag::class);
    }


    /**
     * Kategorie dle názve
     * @param string $title
     *
     * @return mixed|null|object
     */
    public function findByTitle($title)
    {

       return $this->repository->findOneBy(array("title" => $title));

    }


    /**
     * @param $title
     *
     * @return mixed|null|object
     */
    public function findByWebalizeTitle($title)
    {
        $title = Nette\Utils\Strings::webalize($title);
        return $this->repository->findOneBy(array("webalizeTitle" => $title));
    }

    /**
     * Kategorie dle id
     * @param int $id
     *
     * @return mixed|null|object
     */
    public function findById($id)
    {
        return $this->repository->find($id);
    }

    /**
     * @return array
     */
    public function findAll()
    {
        return $this->repository->findAll();
    }

    public function findForArchive()
    {

        return $this->repository->findBy(array(), array('title'=>'asc'));
    }

}