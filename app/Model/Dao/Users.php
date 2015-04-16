<?php
/**
 * Created by PhpStorm.
 * User: ondrej.votava
 * Date: 16. 4. 2015
 * Time: 10:55
 */

namespace App\Model\Dao;

use App\Model\Entities;
use Nette;
use Kdyby;

/**
 * Class Users
 * @package App\Model\Dao
 * @author Ondra Votava <ja@ondravotava.cz>
 */

class Users extends Nette\Object
{

    /**
     * @var \Kdyby\Doctrine\EntityDao
     */
    protected $dao;

    public function __construct(Kdyby\Doctrine\EntityDao $dao)
    {
        $this->dao = $dao;
    }

    /**
     * @param $username
     *
     * @return null|Entities\User
     */
    public function findByUsername($username)
    {
        return $this->dao->findOneBy(array('username' => $username));
    }

    /**
     * @param $id
     *
     * @return mixed|null|object
     */
    public function findById($id)
    {

        return $this->dao->findOneBy(array('id' => $id));
    }
}