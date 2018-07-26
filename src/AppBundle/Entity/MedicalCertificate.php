<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 3/9/18
 * Time: 2:46 PM
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="agp_dossier_medical_certificate")
 * @ORM\HasLifecycleCallbacks
 */
class MedicalCertificate {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Dossier", inversedBy="medicalCertificate")
     * @ORM\JoinColumn(name="dossier_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $dossier;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $dateUploaded;

    /**
     * @ORM\Column(type="string")
     */
    private $doctorName;

    /**
     * @ORM\Column(type="string")
     */
    private $doctorPhone;

    /**
     * @ORM\Column(type="string")
     */
    private $date;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\MedicalCertificateImage", mappedBy="medicalCertificate", cascade={"all"})
     * @Assert\Valid
     */
    private $image;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\MedicalCertificateSurveyImage", mappedBy="medicalCertificate", cascade={"all"})
     * @Assert\Valid
     */
    private $medicalSurvey;

    public function __construct() {
        $this->dateUploaded = new \DateTime();
    }

    /**
     * @return mixed
     */
    public function getDoctorName() {
        return $this->doctorName;
    }

    /**
     * @param mixed $doctorName
     */
    public function setDoctorName($doctorName) {
        $this->doctorName = $doctorName;
    }

    /**
     * @return mixed
     */
    public function getDoctorPhone() {
        return $this->doctorPhone;
    }

    /**
     * @param mixed $doctorPhone
     */
    public function setDoctorPhone($doctorPhone) {
        $this->doctorPhone = $doctorPhone;
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
    public function getDossier() {
        return $this->dossier;
    }

    /**
     * @param mixed $dossier
     */
    public function setDossier($dossier) {
        $this->dossier = $dossier;
    }

    /**
     * @return \DateTime
     */
    public function getDateUploaded() {
        return $this->dateUploaded;
    }

    /**
     * @param \DateTime $dateUploaded
     */
    public function setDateUploaded($dateUploaded) {
        $this->dateUploaded = $dateUploaded;
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
    public function getMedicalSurvey()
    {
        return $this->medicalSurvey;
    }

    /**
     * @param mixed $medicalSurvey
     */
    public function setMedicalSurvey($medicalSurvey)
    {
        $this->medicalSurvey = $medicalSurvey;
    }
}
