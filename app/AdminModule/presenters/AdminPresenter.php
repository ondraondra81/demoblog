<?php
/**
 * Created by PhpStorm.
 * User: ondrej.votava
 * Date: 13. 4. 2015
 * Time: 18:16
 */

namespace App\AdminModule\Presenters;


use Nette;
use App\AdminModule\Componentes\Form\UserForm;

/**
 * Class AdminPresenter
 * @package App\AdminModule\Presenters
 * @author Ondra Votava <ja@ondravotava.cz>
 */

class AdminPresenter extends BaseAdminPresenter
{

    /**
     * @var UserForm $userForm
     */
    protected $userForm;

    /**
     * @param UserForm $userForm
     */
    public function injectUserForm(UserForm $userForm)
    {

        $this->userForm = $userForm;
    }

    /**
     * @return Nette\Application\UI\Form
     */
    public function createComponentUserForm()
    {

        $id = $this->getPresenter()->getParameter('id');
        return $form = $this->userForm->create($id);

    }

    # aby presenter ukazoval id v url adrese
    public function renderManageuser($id)
    {

    }

    public function renderDefault()
    {

    }
}