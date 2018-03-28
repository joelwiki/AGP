<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 3/9/18
 * Time: 1:58 PM
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="agp_dossier")
 */
class Dossier {
    /**
     * @ORM\Id
     * @ORM\Column(type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="uniqueId", type="string")
     */
    private $uniqueId;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $enabled;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\DossierImage", mappedBy="dossier", cascade={"all"})
     */
    protected $image;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\User", inversedBy="dossier")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $firstName;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $lastName;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $sex;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $shirtSize;

    /**
     * @ORM\Column(type="string")
     */
    private $paymentType;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date")
     * @Assert\NotBlank()
     */
    private $birthDate;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $street;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     */
    private $zipCode;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $city;

    /**
     * @ORM\Column(type="string")
     * @Assert\Email()
     * @Assert\NotBlank()
     */
    private $email;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $emergencyContactFirstName;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $emergencyContactLastName;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $emergencyContactPhone;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $emergencyContactRelation;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $emergencyContactTwoFirstName;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $emergencyContactTwoLastName;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $emergencyContactTwoPhone;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $emergencyContactTwoRelation;

    /**
     * @ORM\Column(type="boolean")
     */
    private $parentalAuthorization;

    /**
     * @ORM\Column(type="boolean")
     */
    private $imageRight;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\NotBlank()
     */
    private $responsability;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\NotBlank()
     */
    private $termsOfAgreement;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\CivilCertificate", mappedBy="dossier", cascade={"all"})
     * @Assert\NotBlank()
     */
    private $civilLiabilityCertificate;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\MedicalCertificate", mappedBy="dossier", cascade={"all"})
     * @Assert\NotBlank()
     */
    private $medicalCertificate;

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
    public function getEnabled() {
        return $this->enabled;
    }

    /**
     * @param mixed $enabled
     */
    public function setEnabled($enabled) {
        $this->enabled = $enabled;
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
    public function getFirstName() {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName) {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName() {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName) {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getSex() {
        return $this->sex;
    }

    /**
     * @param mixed $sex
     */
    public function setSex($sex) {
        $this->sex = $sex;
    }

    /**
     * @return mixed
     */
    public function getShirtSize() {
        return $this->shirtSize;
    }

    /**
     * @param mixed $shirtSize
     */
    public function setShirtSize($shirtSize) {
        $this->shirtSize = $shirtSize;
    }

    /**
     * @return \DateTime
     */
    public function getBirthDate() {
        return $this->birthDate;
    }

    /**
     * @param \DateTime $birthDate
     */
    public function setBirthDate($birthDate) {
        $this->birthDate = $birthDate;
    }

    /**
     * @return mixed
     */
    public function getStreet() {
        return $this->street;
    }

    /**
     * @param mixed $street
     */
    public function setStreet($street) {
        $this->street = $street;
    }

    /**
     * @return mixed
     */
    public function getZipCode() {
        return $this->zipCode;
    }

    /**
     * @param mixed $zipCode
     */
    public function setZipCode($zipCode) {
        $this->zipCode = $zipCode;
    }

    /**
     * @return mixed
     */
    public function getCity() {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city) {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email) {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPhone() {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone) {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getParentalAuthorization() {
        return $this->parentalAuthorization;
    }

    /**
     * @param mixed $parentalAuthorization
     */
    public function setParentalAuthorization($parentalAuthorization) {
        $this->parentalAuthorization = $parentalAuthorization;
    }

    /**
     * @return mixed
     */
    public function getImageRight() {
        return $this->imageRight;
    }

    /**
     * @param mixed $imageRight
     */
    public function setImageRight($imageRight) {
        $this->imageRight = $imageRight;
    }

    /**
     * @return mixed
     */
    public function getResponsability() {
        return $this->responsability;
    }

    /**
     * @param mixed $responsability
     */
    public function setResponsability($responsability) {
        $this->responsability = $responsability;
    }

    /**
     * @return mixed
     */
    public function getTermsOfAgreement() {
        return $this->termsOfAgreement;
    }

    /**
     * @param mixed $termsOfAgreement
     */
    public function setTermsOfAgreement($termsOfAgreement) {
        $this->termsOfAgreement = $termsOfAgreement;
    }

    /**
     * @return mixed
     */
    public function getCivilLiabilityCertificate() {
        return $this->civilLiabilityCertificate;
    }

    /**
     * @param mixed $civilLiabilityCertificate
     */
    public function setCivilLiabilityCertificate($civilLiabilityCertificate) {
        $this->civilLiabilityCertificate = $civilLiabilityCertificate;
    }

    /**
     * @return mixed
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user) {
        $this->user = $user;
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
    public function getEmergencyContactFirstName() {
        return $this->emergencyContactFirstName;
    }

    /**
     * @param mixed $emergencyContactFirstName
     */
    public function setEmergencyContactFirstName($emergencyContactFirstName) {
        $this->emergencyContactFirstName = $emergencyContactFirstName;
    }

    /**
     * @return mixed
     */
    public function getEmergencyContactLastName() {
        return $this->emergencyContactLastName;
    }

    /**
     * @param mixed $emergencyContactLastName
     */
    public function setEmergencyContactLastName($emergencyContactLastName) {
        $this->emergencyContactLastName = $emergencyContactLastName;
    }

    /**
     * @return mixed
     */
    public function getEmergencyContactPhone() {
        return $this->emergencyContactPhone;
    }

    /**
     * @param mixed $emergencyContactPhone
     */
    public function setEmergencyContactPhone($emergencyContactPhone) {
        $this->emergencyContactPhone = $emergencyContactPhone;
    }

    /**
     * @return mixed
     */
    public function getEmergencyContactRelation() {
        return $this->emergencyContactRelation;
    }

    /**
     * @param mixed $emergencyContactRelation
     */
    public function setEmergencyContactRelation($emergencyContactRelation) {
        $this->emergencyContactRelation = $emergencyContactRelation;
    }

    /**
     * @return mixed
     */
    public function getEmergencyContactTwoFirstName() {
        return $this->emergencyContactTwoFirstName;
    }

    /**
     * @param mixed $emergencyContactTwoFirstName
     */
    public function setEmergencyContactTwoFirstName($emergencyContactTwoFirstName) {
        $this->emergencyContactTwoFirstName = $emergencyContactTwoFirstName;
    }

    /**
     * @return mixed
     */
    public function getEmergencyContactTwoLastName() {
        return $this->emergencyContactTwoLastName;
    }

    /**
     * @param mixed $emergencyContactTwoLastName
     */
    public function setEmergencyContactTwoLastName($emergencyContactTwoLastName) {
        $this->emergencyContactTwoLastName = $emergencyContactTwoLastName;
    }

    /**
     * @return mixed
     */
    public function getEmergencyContactTwoPhone() {
        return $this->emergencyContactTwoPhone;
    }

    /**
     * @param mixed $emergencyContactTwoPhone
     */
    public function setEmergencyContactTwoPhone($emergencyContactTwoPhone) {
        $this->emergencyContactTwoPhone = $emergencyContactTwoPhone;
    }

    /**
     * @return mixed
     */
    public function getEmergencyContactTwoRelation() {
        return $this->emergencyContactTwoRelation;
    }

    /**
     * @param mixed $emergencyContactTwoRelation
     */
    public function setEmergencyContactTwoRelation($emergencyContactTwoRelation) {
        $this->emergencyContactTwoRelation = $emergencyContactTwoRelation;
    }

    /**
     * @return mixed
     */
    public function getPaymentType() {
        return $this->paymentType;
    }

    /**
     * @param mixed $paymentType
     */
    public function setPaymentType($paymentType) {
        $this->paymentType = $paymentType;
    }
}


