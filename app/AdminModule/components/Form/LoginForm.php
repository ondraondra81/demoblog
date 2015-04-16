<?php
/**
 * Created by PhpStorm.
 * User: ondrej.votava
 * Date: 16. 4. 2015
 * Time: 15:17
 */

namespace App\AdminModule\Componentes\Form;

use Nette;
use Nette\Security as NS;
use Nette\Application\UI\Form;


/**
 * Class LoginForm
 * @package App\Form
 * @author  Ondra Votava <ja@ondravotava.cz>
 * @copyright Ondra Votava <ja@ondravotava.cz>
 */
class LoginForm extends Nette\Object
{
    /** @var NS\User */
    private $user;

    /**
     * @param NS\User $user
     */
    public function __construct(NS\User $user)
    {
        $this->user = $user;
    }

    /**
     * Vytovoření formuláře pro přihlášení
     * @return Form
     */
    public function create()
    {

        $form = new Form();
        $form->addText('username', 'Uživ. jméno')
            ->addRule(Form::FILLED, 'musíte zadat jméno');
        $form->addPassword('password', 'Heslo:')
            ->addRule(Form::FILLED, 'Musíte zadat heslo');
        $form->addSubmit('send','Přihlásit');

        $form->onSuccess[] = $this->loginProcess;

        return $form;

    }

    /**
     * Zpracování formuláře pro přihlášení
     * @param Form $form
     * @param array $values
     *
     */
    public function loginProcess(Form $form, $values)
    {

        try {
            $this->user->login($values->username, $values->password);
        }
        catch (NS\AuthenticationException $e) {
            $form->addError($e->getMessage());
        }

    }

}