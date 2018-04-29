<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 3/6/18
 * Time: 2:12 PM
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="agp_article")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ArticleRepository")
 */
class Article {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="uniqueId", type="string")
     */
    private $uniqueId;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id")
     */
    private $author;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\ArticleImage", mappedBy="article", cascade={"all"})
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $image;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     * @Assert\DateTime()
     */
    private $datePublished;

    /**
     * @ORM\Column(type="string")
     */
    private $slug;

    public function __construct() {
        $this->datePublished = new \DateTime();
    }

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title) {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getContent() {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content) {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getAuthor() {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author) {
        $this->author = $author;
    }

    /**
     * @return string
     */
    public function getUniqueId() {
        return $this->uniqueId;
    }

    /**
     * @param string $uniqueId
     */
    public function setUniqueId($uniqueId) {
        $this->uniqueId = $uniqueId;
    }

    /**
     * @return mixed
     */
    public function getImage() {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image) {
        $this->image = $image;
    }

    /**
     * @return \DateTime
     */
    public function getDatePublished() {
        return $this->datePublished;
    }

    /**
     * @param \DateTime $datePublished
     */
    public function setDatePublished($datePublished) {
        $this->datePublished = $datePublished;
    }

    /**
     * @return mixed
     */
    public function getSlug() {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug($slug) {
        $this->slug = $slug;
    }
}
