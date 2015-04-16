<?php
/**
 * Created by PhpStorm.
 * User: ondrej.votava
 * Date: 13. 4. 2015
 * Time: 18:16
 */

namespace App\AdminModule\Presenters;


use Nette;
use Nette\Application\UI\Presenter;
use App\AdminModule\Componentes\Form\UserForm;

/**
 * Class AdminPresenter
 * @package App\AdminModule\Presenters
 * @author Ondra Votava <ja@ondravotava.cz>
 */

class AdminPresenter extends Presenter
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

    /**
     * Pokud neni uživatel přihlášen přesměrujeme ho na přihlašovací stránku
     */
    public function beforeRender()
    {
        if(!$this->getUser()->isLoggedIn()){
            $this->redirect("Login:default");
        }

    }

    public function renderDefault()
    {

    }
}