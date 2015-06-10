<?php
/**
 * Created by PhpStorm.
 * User: ondrej.votava
 * Date: 19. 3. 2015
 * Time: 10:14
 */

namespace App\Model\Repository;

use App\Model\Entities;
use Nette;
use Kdyby;
use Nette\Utils\DateTime;

/**
 * Class Articles
 * @package App\Model\Dao
 * @author Ondra Votava <ja@ondravotava.cz>
 */

class Articles extends Nette\Object
{

    /**
     * @var Kdyby\Doctrine\EntityManager $em
     */
    private $em;

    /**
     * @var Kdyby\Doctrine\EntityRepository $repository
     */
    private $repository;

    public function __construct(Kdyby\Doctrine\EntityManager $entityManager)
    {
        $this->em = $entityManager;
        $this->repository = $this->em->getRepository(Entities\Article::class);
    }


    /**
     * Vrátí entity manager
     * @return Kdyby\Doctrine\EntityManager
     */
    public function getEntityManager()
    {

        return $this->em;
    }

    /**
     * Article podle nazvu
     * @param $title string
     * @return Entities\Article
     */
    public function findByTitle($title)
    {

        return $this->repository->findOneBy(array("webalizeTitle" => $title));

    }



    /**
     * Vrati article podle Id
     *
     * @param $id
     *
     * @return mixed|null|object
     */
    public function findById($id)
    {

        return $this->repository->findOneBy(array('id' => $id));

    }



    /**
     * Vrátí všechny articles které jsou publikované podle data od nejmladsiho
     * @return Kdyby\Doctrine\ResultSet
     */
    public function findPublishedArticle()
    {

        $dql = $this->createAllQuery();
        return new Kdyby\Doctrine\ResultSet($dql);
    }



    /**
     * Posledních 50 Articles pro rss, od nejmladšího
     * @return Kdyby\Doctrine\ResultSet
     */
    public function findForRss()
    {

        $dql = $this->createAllQuery();

        return new Kdyby\Doctrine\ResultSet($dql->setMaxResults(50));

    }

    /**
     * @return \Doctrine\ORM\Query
     */
    private function createAllQuery()
    {

        $dql = $this->repository->createQuery("SELECT a From App\Model\Entities\Article a
                WHERE a.published = true and a.publishDate <= :date
                ORDER BY a.publishDate DESC");

        $dql->setParameter('date', new DateTime('now'));

        return $dql;
    }

    /**
     * Všechny Article řazené od nejmladšího po nejstraší
     * @return array
     */
    public function findAll()
    {

       return $this->repository->findBy(array(), array('publishDate' => 'DESC'));

    }

}
