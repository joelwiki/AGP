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
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DossierRepository")
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
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $enabled;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\DossierImage", mappedBy="dossier", cascade={"all"})
     */
    protected $image;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\User", inversedBy="dossier")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $user;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\Regex(
     *      pattern = "/^[a-zA-ZÀ-ÿ\-']*$/",
     *      message = "Le prénom n'est pas valide."
     * )
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Le prénom doit contenir au moins {{ limit }} lettres.",
     *      maxMessage = "Le prénom ne peut pas excéder {{ limit }} lettres."
     * )
     */
    private $firstName;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\Regex(
     *      pattern = "/^[a-zA-ZÀ-ÿ\-']*$/",
     *      message = "Le nom n'est pas valide."
     * )
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Le nom doit contenir au moins {{ limit }} lettres.",
     *      maxMessage = "Le nom ne peut pas excéder {{ limit }} lettres."
     * )
     */
    private $lastName;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $sex;

    /**
     * @ORM\Column(type="string")
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
     * @Assert\DateTime(
     *     format="d-m-Y",
     *     message="Format de date incorrect, format attendu : '{{ format }}'."
     * )
     * @Assert\LessThan(
     *     value="today",
     *     message="La date de naissance doit être inférieure au {{ value }}."
     * )
     */
    private $birthDate;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "La rue doit contenir au moins {{ limit }} lettres.",
     *      maxMessage = "La rue ne peut pas excéder {{ limit }} lettres.",
     * )
     */
    private $street;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     * @Assert\Range(
     *      min = 01000,
     *      max = 99999,
     *      minMessage = "Le code postal doit être au minimum 01000.",
     *      maxMessage = "Le code postal doit être au maximum 99999.",
     *      invalidMessage = "Le code postal doit être un nombre."
     * )
     */
    private $zipCode;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "La ville doit contenir au moins {{ limit }} lettres.",
     *      maxMessage = "La ville ne peut pas excéder {{ limit }} lettres.",
     * )
     */
    private $city;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\Email(
     *     message = "L'adresse '{{ value }}' n'est pas valide.",
     *     checkMX = true
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="string")
     * @Assert\Type(
     *      type = "alnum",
     *      message = "Le numéro de téléphone ne doit contenir que des chiffres."
     * )
     */
    private $phone;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\Regex(
     *      pattern = "/^[a-zA-ZÀ-ÿ\-']*$/",
     *      message = "Le prénom du contact n'est pas valide."
     * )
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Le prénom doit contenir au moins {{ limit }} lettres.",
     *      maxMessage = "Le prénom ne peut pas excéder {{ limit }} lettres."
     * )
     */
    private $emergencyContactFirstName;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\Regex(
     *      pattern = "/^[a-zA-ZÀ-ÿ\-']*$/",
     *      message = "Le nom du contact n'est pas valide."
     * )
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Le nom doit contenir au moins {{ limit }} lettres.",
     *      maxMessage = "Le nom ne peut pas excéder {{ limit }} lettres."
     * )
     */
    private $emergencyContactLastName;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\Type(
     *      type = "alnum",
     *      message = "Le numéro de téléphone de contact ne doit contenir que des chiffres."
     * )
     */
    private $emergencyContactPhone;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $emergencyContactRelation;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Regex(
     *      pattern = "/^[a-zA-ZÀ-ÿ\-']*$/",
     *      message = "Le prénom du second contact n'est pas valide."
     * )
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Le prénom doit contenir au moins {{ limit }} lettres.",
     *      maxMessage = "Le prénom ne peut pas excéder {{ limit }} lettres."
     * )
     */
    private $emergencyContactTwoFirstName;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Regex(
     *      pattern = "/^[a-zA-ZÀ-ÿ\-']*$/",
     *      message = "Le nom du second contact n'est pas valide."
     * )
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Le nom doit contenir au moins {{ limit }} lettres.",
     *      maxMessage = "Le nom ne peut pas excéder {{ limit }} lettres."
     * )
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
     */
    private $civilLiabilityCertificate;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\MedicalCertificate", mappedBy="dossier", cascade={"all"})
     */
    private $medicalCertificate;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $fpkNumber;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $fpkRegistered;

    /**
     * @ORM\Column(type="boolean")
     */
    private $hasPaidMembership;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Type(
     *      type = "integer",
     *      message = "Le montant payé doit être un nombre."
     * )
     */
    private $paidAmount;

    public function __construct() {
        $this->hasPaidMembership = 0;
        $this->paidAmount = 0;
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
        $birthDateFormatted = explode('/', $birthDate);
        $birthDateFormatted = new \DateTime($birthDateFormatted[2] . '-' . $birthDateFormatted[1] . '-' . $birthDateFormatted[0]);

        $this->birthDate = $birthDateFormatted;
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
        $phoneFormatted = str_replace(' ', '', $phone);

        $this->phone = $phoneFormatted;
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
        return wordwrap($this->emergencyContactPhone , 2 , '.' , true );
    }

    /**
     * @param mixed $emergencyContactPhone
     */
    public function setEmergencyContactPhone($emergencyContactPhone) {
        $emergencyContactPhoneFormatted = str_replace(' ', '', $emergencyContactPhone);

        $this->emergencyContactPhone = $emergencyContactPhoneFormatted;
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
        return wordwrap($this->emergencyContactPhone , 2 , '.' , true );
    }

    /**
     * @param mixed $emergencyContactTwoPhone
     */
    public function setEmergencyContactTwoPhone($emergencyContactTwoPhone) {
        $emergencyContactTwoPhoneFormatted = str_replace(' ', '', $emergencyContactTwoPhone);

        $this->emergencyContactTwoPhone = $emergencyContactTwoPhoneFormatted;
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

    /**
     * @return mixed
     */
    public function getFpkNumber() {
        return $this->fpkNumber;
    }

    /**
     * @param mixed $fpkNumber
     */
    public function setFpkNumber($fpkNumber) {
        $this->fpkNumber = $fpkNumber;
    }

    /**
     * @return mixed
     */
    public function getFpkRegistered() {
        return $this->fpkRegistered;
    }

    /**
     * @param mixed $fpkRegistered
     */
    public function setFpkRegistered($fpkRegistered) {
        $this->fpkRegistered = $fpkRegistered;
    }

    /**
     * @return mixed
     */
    public function getHasPaidMembership()
    {
        return $this->hasPaidMembership;
    }

    /**
     * @param mixed $hasPaidMembership
     */
    public function setHasPaidMembership($hasPaidMembership)
    {
        $this->hasPaidMembership = $hasPaidMembership;
    }

    /**
     * @return mixed
     */
    public function getPaidAmount()
    {
        return $this->paidAmount;
    }

    /**
     * @param mixed $paidAmount
     */
    public function setPaidAmount($paidAmount)
    {
        $this->paidAmount = $paidAmount;
    }
}