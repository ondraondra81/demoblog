<?php
/**
 * Created by PhpStorm.
 * User: ondrej.votava
 * Date: 19. 3. 2015
 * Time: 10:08
 */

namespace App\Model\Entities;


use CreativeDesign\Utils\Text;
use Doctrine\ORM\Mapping AS ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Kdyby\Doctrine\Entities\BaseEntity;
use Kdyby\Doctrine\Entities\Attributes\Identifier;
use Nette\ArgumentOutOfRangeException;
use Nette\Utils\Strings;


/**
 * Class Tag
 * @package App\Model\Entities
 * @author Ondra Votava <ja@ondravotava.cz>
 */

/**
 * @ORM\Entity
 * @ORM\Table(name="tags")
 */

class Tag extends BaseEntity
{

    use Identifier;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    private $title;

    /**
     * @ORM\Column(type="string", nullable=false, unique=true)
     * @var string
     */
    private $webalizeTitle;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    private $tagColor;

    /**
     * @ORM\ManyToMany(targetEntity="App\Model\Entities\Article", mappedBy="tags", cascade={"persist"})
     * @var ArrayCollection Article[]
     */
    protected $articles;

    /********************************* END OF Tag ********************************************************/
    /**
     * @param string $title
     * @param string $color
     */
    public function __construct($title, $color = "#800000")
    {
        $this->setTitle($title);
        $this->articles = new ArrayCollection();
        $this->setColor($color);
    }


    /**
     * @param Article $article
     *
     * @return Article $this
     */
    public function addArticles(Article $article)
    {

        if(!$this->articles->contains($article)){
            $this->articles->add($article);
            return $this;
        }

    }

    /**
     * @param Article $article
     */
    public function removeArticle(Article $article)
    {

        if(!$this->articles->contains($article))
        {
            $this->articles->removeElement($article);
        }
    }


    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
        $this->webalizeTitle = Strings::webalize($title);
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getWebalizeTitle()
    {
        return $this->webalizeTitle;
    }

    /**
     * Get color
     * @return string
     */
    public function getColor()
    {
        return $this->tagColor;
    }

    /**
     * Set Color
     * @param string $c
     */
    public function setColor($c)
    {
        if(Text::validateHexColor($c))
            $this->tagColor = $c;
        else
            throw new ArgumentOutOfRangeException("Argument $c is out of range");

    }
}