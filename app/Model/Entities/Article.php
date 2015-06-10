<?php
/**
 * Created by PhpStorm.
 * User: ondrej.votava
 * Date: 19. 3. 2015
 * Time: 9:22
 */

namespace App\Model\Entities;


use CreativeDesign\Utils\Text;
use Doctrine\ORM\Mapping AS ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Kdyby\Doctrine\Entities\BaseEntity;
use Kdyby\Doctrine\Entities\Attributes\Identifier;
use Nette\InvalidArgumentException;
use Nette\Utils\Strings;
use Nette\Utils\DateTime;


/**
 * Class Article
 * @package App\Entities\
 * @author Ondra Votava <ja@ondravotava.cz>
 */

/**
 * @ORM\Entity
 * @ORM\Table(name="articles")
 */

class Article extends BaseEntity
{

    use Identifier;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    private $title;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    private $webalizeTitle;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @var DateTime
     */
    private $publishDate;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     * @var boolean
     */
    private $published;

     /**
     * @ORM\Column(type="text", nullable=true)
     * @var string
     */
    protected $content;

    /**
     * @ORM\ManyToMany(targetEntity="App\Model\Entities\Tag", inversedBy="articles", cascade={"persist"})
     * @ORM\JoinTable(
     *     name="articles_2_tags",
     *     joinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id", nullable=false)},
     *     inverseJoinColumns={@ORM\JoinColumn(name="article_id", referencedColumnName="id", nullable=false)}
     * )
     * @var ArrayCollection Tag[]
     */
    private $tags;


    /**
     * @param string        $title
     * @param string        $content
     * @param DateTime      $publishDate
     * @param bool          $published
     */
    public function __construct($title, $content, $publishDate, $published = false)
    {
        $this->tags = new ArrayCollection();
        $this->setTitle($title);
        $this->content = $content;
        $this->setPublishDate($publishDate);
        $this->setPublished($published);
    }


    /**
     * @param Tag $tag
     *
     * @return $this
     */
    public function addTag(Tag $tag)
    {

        if (!$this->tags->contains($tag) ) {
            $this->tags->add($tag);
            $tag->addArticles($this);
        }

        return $this;
    }

    /**
     * @param Tag $tag
     *
     * @return Article $this
     */
    public function removeTag(Tag $tag)
    {
        if ( $this->tags->contains($tag) ) {
            $this->tags->removeElement($tag);
            $tag->removeArticle($this);
        }
        return $this;

    }


    /**
     * @param $title
     */
    public function setTitle($title)
    {
        $this->title = Strings::upper($title);
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
     * @param DateTime $date
     */
    public function setPublishDate(DateTime $date)
    {
        $this->publishDate = $date;
    }

    /**
     * @return DateTime
     */
    public function getPublishDate()
    {
        return $this->publishDate;
    }

    /**
     * @return string
     */
    public function getWebalizeTitle()
    {
        return $this->webalizeTitle;
    }

    /**
     * @return bool
     */
    public function isPublished()
    {
        return $this->published;
    }

    /**
     * @param bool $published
     */
    public function setPublished($published = false)
    {

        if (is_bool($published)) {
            $this->published = $published;
        }
        else
        {
            if(is_null(Text::toBool($published)))
                $this->published = false;
            else
                $this->published = Text::toBool($published);
        }

    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return ArrayCollection $tags
     */
    public function getTags()
    {
        return $this->tags;
    }

}
