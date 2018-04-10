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
    private $location;

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
}