<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 3/14/18
 * Time: 6:42 PM
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="agp_training_type")
 */
class TrainingRef {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     */
    private $categoryStart;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     */
    private $categoryEnd;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $weekDay;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $hourStart;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $hourEnd;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Training", mappedBy="trainingType")
     */
    private $trainings;

    public function __construct() {
        $this->trainings = new ArrayCollection();
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
    public function getWeekDay() {
        return $this->weekDay;
    }

    /**
     * @param mixed $weekDay
     */
    public function setWeekDay($weekDay) {
        $this->weekDay = $weekDay;
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
    public function getType() {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type) {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getCategoryStart() {
        return $this->categoryStart;
    }

    /**
     * @param mixed $categoryStart
     */
    public function setCategoryStart($categoryStart) {
        $this->categoryStart = $categoryStart;
    }

    /**
     * @return mixed
     */
    public function getCategoryEnd() {
        return $this->categoryEnd;
    }

    /**
     * @param mixed $categoryEnd
     */
    public function setCategoryEnd($categoryEnd) {
        $this->categoryEnd = $categoryEnd;
    }

    /**
     * Add training
     *
     * @param Training $training
     *
     * @return TrainingRef
     */
    public function addTraining(Training $training)
    {
        $this->trainings[] = $training;

        return $this;
    }

    /**
     * Remove training
     *
     * @param Training $training
     */
    public function removeTraining(Training $training)
    {
        $this->trainings->removeElement($training);
    }
}
