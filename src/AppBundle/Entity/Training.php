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
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TrainingRepository")
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
     * @var \DateTime
     *
     * @ORM\Column(type="date")
     * @Assert\NotBlank()
     */
    private $date;

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
        $dateFormatted = new \DateTime($dateFormatted[2] . '-' . $dateFormatted[1] . '-' . $dateFormatted[0]);

        $this->date = $dateFormatted;
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
