<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 10/04/18
 * Time: 13:52
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="agp_training_location")
 */
class TrainingLocation {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $customLocation;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\TrainingLocationImage", mappedBy="training", cascade={"all"})
     * @Assert\Valid
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Training", mappedBy="trainingLocation")
     */
    private $trainings;

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

    public function __toString () {
        return $this->getCustomLocation();
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
     * @return mixed
     */
    public function getTrainings() {
        return $this->trainings;
    }

    /**
     * @param mixed $trainings
     */
    public function setTrainings($trainings) {
        $this->trainings = $trainings;
    }

    /**
     * @return mixed
     */
    public function getCustomLocation() {
        return $this->customLocation;
    }

    /**
     * @param mixed $customLocation
     */
    public function setCustomLocation($customLocation) {
        $this->customLocation = $customLocation;
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
}