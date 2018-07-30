<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 26/03/18
 * Time: 15:07
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="agp_initiation")
 */
class Initiation {
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
     * @var \DateTime
     * @ORM\Column(type="datetime")
     * @Assert\DateTime()
     */
    private $datePublished;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $location;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="string")
     */
    private $hourStart;

    /**
     * @ORM\Column(type="string")
     */
    private $hourEnd;

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
    public function getLocation() {
        return $this->location;
    }

    /**
     * @param mixed $location
     */
    public function setLocation($location) {
        $this->location = $location;
    }

    /**
     * @return mixed
     */
    public function getHourStart() {
        return $this->hourStart;
    }

    /**
     * @param mixed $hourStart
     */
    public function setHourStart($hourStart) {
        $this->hourStart = $hourStart;
    }

    /**
     * @return mixed
     */
    public function getHourEnd() {
        return $this->hourEnd;
    }

    /**
     * @param mixed $hourEnd
     */
    public function setHourEnd($hourEnd) {
        $this->hourEnd = $hourEnd;
    }

    /**
     * @return \DateTime
     */
    public function getDate() {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date) {
        $dateFormatted = explode('/', $date);
        $dateFormatted = new \DateTime($dateFormatted[2]. '-' . $dateFormatted[1] . '-' . $dateFormatted[0]);

        $this->date = $dateFormatted;
    }
}
