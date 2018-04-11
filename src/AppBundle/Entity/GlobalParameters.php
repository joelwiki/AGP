<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 10/04/18
 * Time: 16:36
 */

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="agp_global_parameters")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GlobalParametersRepository")
 */
class GlobalParameters {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $membershipFee;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date")
     */
    private $globalRegistrationDateStart;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date")
     */
    private $globalRegistrationDateEnd;

    /**
     * @ORM\Column(type="string")
     */
    private $siteName;

    /**
     * @ORM\Column(type="string")
     */
    private $themeColor;

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
    public function getMembershipFee() {
        return $this->membershipFee;
    }

    /**
     * @param mixed $membershipFee
     */
    public function setMembershipFee($membershipFee) {
        $this->membershipFee = $membershipFee;
    }

    /**
     * @return \DateTime
     */
    public function getGlobalRegistrationDateStart() {
        return $this->globalRegistrationDateStart;
    }

    /**
     * @param \DateTime $globalRegistrationDateStart
     */
    public function setGlobalRegistrationDateStart($globalRegistrationDateStart) {
        $this->globalRegistrationDateStart = $globalRegistrationDateStart;
    }

    /**
     * @return \DateTime
     */
    public function getGlobalRegistrationDateEnd() {
        return $this->globalRegistrationDateEnd;
    }

    /**
     * @param \DateTime $globalRegistrationDateEnd
     */
    public function setGlobalRegistrationDateEnd($globalRegistrationDateEnd) {
        $this->globalRegistrationDateEnd = $globalRegistrationDateEnd;
    }

    /**
     * @return mixed
     */
    public function getSiteName() {
        return $this->siteName;
    }

    /**
     * @param mixed $siteName
     */
    public function setSiteName($siteName) {
        $this->siteName = $siteName;
    }

    /**
     * @return mixed
     */
    public function getThemeColor() {
        return $this->themeColor;
    }

    /**
     * @param mixed $themeColor
     */
    public function setThemeColor($themeColor) {
        $this->themeColor = $themeColor;
    }
}