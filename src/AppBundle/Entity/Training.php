<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 3/14/18
 * Time: 7:20 PM
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="agp_training")
 */
class Training {
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TrainingLocation", inversedBy="trainings")
     * @ORM\JoinColumn(name="training_location_id", referencedColumnName="id")
     */
    private $trainingLocation;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TrainingRef", inversedBy="trainings")
     * @ORM\JoinColumn(name="training_type_id", referencedColumnName="id")
     */
    private $trainingType;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $date;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $location;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $lat;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $lng;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $info;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="encadrant_id", referencedColumnName="id")
     */
    private $encadrant;

    /**
     * @ORM\Column(type="boolean")
     */
    private $limitedPlaces;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $places;

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
    public function getTrainingType() {
        return $this->trainingType;
    }

    /**
     * @param mixed $trainingType
     */
    public function setTrainingType($trainingType) {
        $this->trainingType = $trainingType;
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
    public function getInfo() {
        return $this->info;
    }

    /**
     * @param mixed $info
     */
    public function setInfo($info) {
        $this->info = $info;
    }

    /**
     * @return mixed
     */
    public function getLimitedPlaces() {
        return $this->limitedPlaces;
    }

    /**
     * @param mixed $limitedPlaces
     */
    public function setLimitedPlaces($limitedPlaces) {
        $this->limitedPlaces = $limitedPlaces;
    }

    /**
     * @return mixed
     */
    public function getDate() {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date) {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getLat() {
        return $this->lat;
    }

    /**
     * @param mixed $lat
     */
    public function setLat($lat) {
        $this->lat = $lat;
    }

    /**
     * @return mixed
     */
    public function getLng() {
        return $this->lng;
    }

    /**
     * @param mixed $lng
     */
    public function setLng($lng) {
        $this->lng = $lng;
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
    public function getEncadrant() {
        return $this->encadrant;
    }

    /**
     * @param mixed $encadrant
     */
    public function setEncadrant($encadrant) {
        $this->encadrant = $encadrant;
    }

    /**
     * @return mixed
     */
    public function getPlaces() {
        return $this->places;
    }

    /**
     * @param mixed $places
     */
    public function setPlaces($places) {
        $this->places = $places;
    }

    /**
     * @return mixed
     */
    public function getTrainingLocation() {
        return $this->trainingLocation;
    }

    /**
     * @param mixed $trainingLocation
     */
    public function setTrainingLocation($trainingLocation) {
        $this->trainingLocation = $trainingLocation;
    }
}
