<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 3/13/18
 * Time: 1:48 PM
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="agp_dossier_civil_certificate")
 * @ORM\HasLifecycleCallbacks
 */
class CivilCertificate {
    /**
     * @ORM\Id
     * @ORM\Column(type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @ORM\Column(name="extension", type="string", length=255)
     */
    private $extension;

    /**
     * @ORM\Column(name="alt", type="string", length=255)
     */
    private $alt;

    /**
     * @Assert\File(
     *     maxSize="3M",
     *     mimeTypes={ "image/png", "image/jpg", "image/jpeg", },
     *     mimeTypesMessage="Les formats d'image autorisés sont .jpg, .jpeg, .png"
     * )
     * @Assert\Image()
     */
    private $file;

    private $tempFilename;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Dossier", inversedBy="civilLiabilityCertificate")
     * @ORM\JoinColumn(name="dossier_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $dossier;

    /**
     * @ORM\Column(type="integer")
     */
    private $size;

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

        // If thas file
        if ($this->getFile()) {

            $oldFiles = glob($this->getUploadDir() . '/attestation-' . $this->dossier->getUniqueId() . '.*');

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
        return 'uploads/dossier/civil_certificate';
    }

    protected function getUploadRootDir() {
        return __DIR__.'/../../../web/'.$this->getUploadDir();
    }

    public function getWebPath() {
        return $this->getUploadDir().'/'.$this->getId().'.'.$this->getExtension();
    }

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
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
     * @param mixed $file
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