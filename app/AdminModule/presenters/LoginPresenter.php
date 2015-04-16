<?php
/**
 * Created by PhpStorm.
 * User: ondrej.votava
 * Date: 16. 4. 2015
 * Time: 11:31
 */

namespace App\AdminModule\Presenters;

use Nette\Application\UI\Presenter;


/**
 * Class LoginPresenter
 * @package App\AdminModule\Presenters
 * @author Ondra Votava <ja@ondravotava.cz>
 */

class LoginPresenter extends Presenter
{

    /** @var  \App\AdminModule\Componentes\Form\LoginForm @inject */
    public $loginManager;

    /**
     * Create Login Form
     * @return \Nette\Application\UI\Form $form
     */
    public function createComponentLogin()
    {
        $form = $this->loginManager->create();
        $form->onSuccess[] = function ($form)
        {
            $this->getPresenter()->redirect('Admin:default');
        };
        return $form;
    }


    /********************************* End LoginManager ************************************/


    /***/
    public function actionOut()
    {

        $this->getUser()->logout(TRUE);
        $this->redirect('Admin:default');
    }

}