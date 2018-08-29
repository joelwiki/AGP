<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 3/10/18
 * Time: 6:08 PM
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="agp_dossier_medical_certificate_survey_image")
 * @ORM\HasLifecycleCallbacks
 */
class MedicalCertificateSurveyImage {
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="extension", type="string", length=255, nullable=true)
     */
    private $extension;

    /**
     * @ORM\Column(name="alt", type="string", length=255)
     */
    private $alt;

    /**
     * @Assert\File(
     *     maxSize="5M",
     *     mimeTypes={ "image/png", "image/jpg", "image/jpeg", "application/pdf", "application/x-pdf" },
     *     mimeTypesMessage="Les formats d'image autorisés sont .jpg, .jpeg, .png ou .pdf"
     * )
     */
    private $file;

    private $tempFilename;

    /**
     * @ORM\Column(type="integer")
     */
    private $size;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\MedicalCertificate", inversedBy="medicalSurvey")
     * @ORM\JoinColumn(name="certificate_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $medicalCertificate;

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload() {

        // If there's not file, do nothing
        if (null === $this->file) {
            return;
        }

        // Set alt to file name
        $this->alt = $this->file->getClientOriginalName();

        // Set file extension
        $this->extension = $this->file->guessClientExtension();
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload() {
        // If there's no file, do nothing
        if (null === $this->file) {
            return;
        }

        // If has file
        if ($this->getFile()) {

            $oldFiles = glob($this->getUploadDir() . '/questionnaire-' . $this->medicalCertificate->getDossier()->getUniqueId() . '.*');

            // Remove previous file
            if (file_exists($this->getFile())) {
                foreach ($oldFiles as $oldFile) {
                    unlink($oldFile);
                }
            }
        }
    }

    /**
     * @ORM\PreRemove()
     */
    public function preRemoveUpload() {
        // Temporary save the file name
        $this->tempFilename = $this->getUploadRootDir() . '/' . $this->id . '.' . $this->extension;
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload() {
        if (file_exists($this->tempFilename)) {
            unlink($this->tempFilename);
        }
    }

    public function getUploadDir() {
        return 'uploads/dossier/medical_certificate/medical_survey';
    }

    protected function getUploadRootDir() {
        return __DIR__ . '/../../../web/' . $this->getUploadDir();
    }

    public function getWebPath() {
        return $this->getUploadDir() . '/' . $this->getId() . '.' . $this->getExtension();
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
    public function getExtension() {
        return $this->extension;
    }

    /**
     * @param mixed $extension
     */
    public function setExtension($extension) {
        $this->extension = $extension;
    }

    /**
     * @return mixed
     */
    public function getAlt() {
        return $this->alt;
    }

    /**
     * @param mixed $alt
     */
    public function setAlt($alt) {
        $this->alt = $alt;
    }

    /**
     * @return mixed
     */
    public function getFile() {
        return $this->file;
    }

    /**
     * @param $file
     */
    public function setFile($file) {
        $this->file = $file;
    }

    /**
     * @return mixed
     */
    public function getTempFilename() {
        return $this->tempFilename;
    }

    /**
     * @param mixed $tempFilename
     */
    public function setTempFilename($tempFilename) {
        $this->tempFilename = $tempFilename;
    }

    /**
     * @return mixed
     */
    public function getMedicalCertificate() {
        return $this->medicalCertificate;
    }

    /**
     * @param mixed $medicalCertificate
     */
    public function setMedicalCertificate($medicalCertificate) {
        $this->medicalCertificate = $medicalCertificate;
    }

    /**
     * @return mixed
     */
    public function getSize() {
        return $this->size;
    }

    /**
     * @param mixed $size
     */
    public function setSize($size) {
        $this->size = $size;
    }
}
