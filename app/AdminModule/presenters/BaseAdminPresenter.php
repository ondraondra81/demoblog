<?php
/**
 * User: ondrej.votava
 * Date: 20. 8. 2014
 * Time: 11:18
 */
/**
 * Class BaseAdminPresenter
 * @package App\AdminModule\Presenters
 * @author ondrej.votava
 */


namespace App\AdminModule\Presenters;


use CreativeDesign\Utils\Texy\FshlHtmlOutput;
use CreativeDesign\Utils\Texy\TexyProcessor;
use FSHL\Highlighter;
use Nette\Application\UI;
use WebLoader\LoaderFactory;
use WebLoader;
use TexylaLoader;
use Nette;

/**
 * Class BaseAdminPresenter
 * @package App\AdminModule\Presenters
 * @author  Ondra Votava <ja@ondravotava.cz>
 */
abstract class BaseAdminPresenter extends UI\Presenter
{

    /** @var LoaderFactory @inject */
    public $webLoader;

    /** @var \CreativeDesign\Utils\Texy\TexyConfig  @inject */
    public $configurator;

    /** @var  \App\BlogSettings @inject */
    public $blogSettings;

    /**
     * Texyla loader factory
     * @return TexylaLoader
     */
    protected function createComponentTexyla()
    {
        $baseUri = $this->getHttpRequest()->getUrl()->getBaseUrl();
        $links = array(
            "baseUri" => $baseUri,
            "previewPath" => $this->link("Texyla:preview"),
            "filesPath" => $this->link("Texyla:listFiles"),
            "filesUploadPath" => $this->link("Texyla:upload"),
            "filesMkDirPath" => $this->link("Texyla:mkDir"),
            "filesRenamePath" => $this->link("Texyla:rename"),
            "filesDeletePath" => $this->link("Texyla:delete"),
        );
        \Tracy\Debugger::barDump($links, 'links');
        $filter = new WebLoader\Filter\VariablesFilter($links);
        $param = $this->context->getParameters();


        $texyla = new TexylaLoader($filter, $baseUri."webtemp", $param['wwwDir'].'/webtemp/');
        return $texyla;

    }


    /**
     * @param null $class
     *
     * @return UI\ITemplate
     */
    protected function createTemplate($class = NULL)
    {
        $template = parent::createTemplate($class);
        $template->addFilter('texy',
            function ($input) {
                $texy = new TexyProcessor(new Highlighter(new FshlHtmlOutput(),Highlighter::OPTION_DEFAULT),$this->configurator, TexyProcessor::LINE_NUMS_DISABLE);
                $html = new Nette\Utils\Html();
                return $html::el()->setHtml($texy->process($input));
            });
        return $template;
    }


    public function beforeRender()
    {

        if(!$this->getUser()->isLoggedIn()){
            $this->redirect("Login:default");
        }
        $this->template->blogSettings = $this->blogSettings;
    }
}
