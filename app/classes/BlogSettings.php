<?php
/**
 * Created by PhpStorm.
 * User: ondrej.votava
 * Date: 8. 4. 2015
 * Time: 7:48
 */

namespace App;

use Nette;
/**
 * Class BlogConfig
 * @package App
 * @author Ondra Votava <ja@ondravotava.cz>
 */

class BlogSettings extends Nette\Object
{

    /** @var  string $webSiteName */
    public $webSiteName;
    /** @var  string $webSiteLogo */
    public $webSiteLogo;
    /** @var  string $webSiteUrl */
    public $webSiteUrl;
    /** @var  string $webSiteEmail */
    public $webSiteEmail;

    /**
     * @param array $setting
     */
    public function __construct($setting)
    {

        $this->webSiteName = $setting['webSiteName'];
        $this->webSiteLogo = $setting['webSiteLogo'];
        $this->webSiteUrl = $setting['webSiteUrl'];
        $this->webSiteEmail= $setting['webSiteEmail'];

    }

}