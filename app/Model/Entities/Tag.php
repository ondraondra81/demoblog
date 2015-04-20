<?php
/**
 * Created by PhpStorm.
 * User: ondrej.votava
 * Date: 19. 3. 2015
 * Time: 10:08
 */

namespace App\Model\Entities;


use Doctrine\ORM\Mapping AS ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Kdyby;




/**
 * Class Tag
 * @package App\Model\Entities
 * @author Ondra Votava <ja@ondravotava.cz>
 */

/**
 * @ORM\Entity
 * @ORM\Table(name="tags")
 */

class Tag extends Kdyby\Doctrine\Entities\BaseEntity
{

    use Kdyby\Doctrine\Entities\Attributes\Identifier;

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
        $this->setColor($color);
        $this->articles = new ArrayCollection();
    }


    /**
     * @param Article $article
     *
     * @return Article $this
     */
    public function addArticles(Article $article)
    {

        # provedeme puze pokud již $article v ArrayCollection nexistuje
        if(!$this->articles->contains($article)){

            $this->articles->add($article); # pridáme do ArrayCollection

            # vložíme i do entity reprezentující Article, protože je to vlasnící strana a EntityManager sleduje pouze jí
            $article->addTag($this);

            return $this;
        }

    }

    /**
     * @param Article $article
     */
    public function removeArticle(Article $article)
    {

        # pokud je entita Article pritomna
        if($this->articles->contains($article))
        {
            $this->articles->removeElement($article); # odebereme ji
        }
    }


    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
        $this->webalizeTitle = \Nette\Utils\Strings::webalize($title);
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
     * Get color hashtag
     * @return string
     */
    public function getColor()
    {
        return $this->tagColor;
    }

    /**
     * Set Color, barva musí být ve formátu #xxx nebo #xxxxxx
     *
    *@param string $color
     */
    public function setColor($color)
    {
        if(\CreativeDesign\Utils\Text::validateHexColor($color))
            $this->tagColor = $color;
        else
            throw new \Nette\ArgumentOutOfRangeException("Argument $color is out of range");

    }
}