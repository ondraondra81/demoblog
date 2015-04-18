<?php
/**
 * Created by PhpStorm.
 * User: ondrej.votava
 * Date: 16. 4. 2015
 * Time: 11:36
 */

namespace App\AdminModule\Componentes\Form;

use App\Model\Entities\User;
use Nette;
use App\Model\Repository;
use Nette\Application\UI\Form;
use Kdyby\Doctrine\EntityManager;

/**
 * Class UserForm
 * @package App\AdminModule\Componentes\Form
 * @author Ondra Votava <ja@ondravotava.cz>
 */

class UserForm extends Nette\Object
{

    /**
     * @var  Repository\Users $users
     */
    private $users;

    /**
     * @var  EntityManager $em
     */
    private $em;

    public function __construct(Repository\Users $users, EntityManager $entityManager)
    {

        $this->users = $users;
        $this->em = $entityManager;

    }


    /**
     * @param integer $id
     *
     * @return Form
     */
    public function create($id = null)
    {
        $form = new Form();
        # uživatelské jméno
        $form->addText('username', 'Uživatelské jméno:')
            ->addRule(Form::FILLED, 'Toto pole je povinné');
        # heslo
        $form->addPassword('password', 'Heslo:');

        $form->addPassword('password2', 'Ověření hesla:')
            ->addConditionOn($form["password"], Form::FILLED)
                ->addRule(Form::EQUAL, "Hesla se musí shodovat !", $form["password"]);

        #role
        $form->addSelect('role', 'Role', User::getRoleList())
            ->setPrompt('Zvolte Roly')
            ->addRule(Form::FILLED, 'Vyberte roly uživatele');

        #id
        $form->addHidden('id');

        $form->addSubmit('send', 'Uložit');

        if(!is_null($id))
        {
            /** @var User $user */
            $user = $this->users->findById($id);
            $val['id'] = $user->getId();
            $val['username'] = $user->username;
            $val['role'] = $user->getRole();

            $form->setDefaults($val);
        }

        $form->onSuccess[] = $this->userFormSuccess;

        return $form;
    }

    /**
     * @param Form $form
     */
    public function userFormSuccess(Form $form)
    {
        $values = $form->getValues();

        try{

            if(!$user = $this->users->findByUsername($values->username))
            {
                if(empty($values->password))
                    throw new \InvalidArgumentException('nový uživatel nemůže mít prázdné heslo');

                $user = new User($values->username,$values->password,$values->role);
                # přdáme nevého uživatele EntityManager
                $this->em->persist($user);
                $form->getPresenter()->flashMessage('Uživatel byl vytvořen');

            }

            else
            {
                $user->username = $values->username;
                if(!empty($values->password))
                    $user->setPassword($values->password);
                $user->setRole($values->role);
                $form->getPresenter()->flashMessage('Uživatel byl upraven');
            }

            #uložíme změny
            $this->em->flush();

            #presmerujeme
            \Tracy\Debugger::barDump($user->getId(), 'id');
            $form->getPresenter()->redirect('this', array('id' => $user->getId()));


        }
        catch (\Exception $e)
        {

            $form->addError($e->getMessage());

        }


    }

}

