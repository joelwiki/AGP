<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 3/5/18
 * Time: 10:01 PM
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="agp_user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User extends BaseUser {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    private $firstName;

    /**
     * @ORM\Column(type="string")
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $city;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $birthDate;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $age;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date")
     */
    private $dateRegister;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $phone;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\UserImage", inversedBy="user", cascade={"all"}, orphanRemoval= true)
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id")
     * @Assert\Valid
     */
    private $image;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Dossier", mappedBy="user")
     */
    private $dossier;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\User", mappedBy="parent")
     */
    private $children;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Group")
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id")
     */
    protected $group;

    public function __construct()
    {
        parent::__construct();

        $this->dateRegister = new \DateTime();
        $this->children = new ArrayCollection();
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
     * @return string
     */
    public function getName()
    {
        return $this->getFirstName().' '.$this->getLastName();
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
    public function getBirthDate() {
        return $this->birthDate;
    }

    /**
     * @param mixed $birthDate
     */
    public function setBirthDate($birthDate) {
        $this->birthDate = $birthDate;
    }

    /**
     * @return mixed
     */
    public function getDateRegister() {
        return $this->dateRegister;
    }

    /**
     * @param mixed $dateRegister
     */
    public function setDateRegister($dateRegister) {
        $this->dateRegister = $dateRegister;
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
     * @param UserImage|null $image
     */
    public function setImage(UserImage $image = null) {
        $this->image = $image;
    }

    /**
     * @return mixed
     */
    public function getImage() {
        return $this->image;
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
     * Set parent
     *
     * @param User $parent
     *
     * @return User
     */
    public function setParent(User $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return User
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add child
     *
     * @param User $child
     *
     * @return User
     */
    public function addChild(User $child)
    {
        $this->children[] = $child;

        return $this;
    }

    /**
     * Remove child
     *
     * @param User $child
     */
    public function removeChild(User $child)
    {
        $this->children->removeElement($child);
    }

    /**
     * Get children
     *
     * @return Collection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @return mixed
     */
    public function getGroup() {
        return $this->group;
    }

    /**
     * @param mixed $group
     */
    public function setGroup($group) {
        $this->group = $group;
    }

    /**
     * @return mixed
     */
    public function getAge() {
        return $this->age;
    }

    /**
     * @param mixed $age
     */
    public function setAge($age) {
        $this->age = $age;
    }
}
