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
    private $registrationDateStart;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date")
     */
    private $registrationDateEnd;

    /**
     * @ORM\Column(type="string")
     */
    private $siteName;

    /**
     * @ORM\Column(type="string")
     */
    private $themeColor;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isRegistrationOpen;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\HeaderImage", mappedBy="global", cascade={"all"})
     */
    private $headerImage;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date")
     */
    private $endOfYearDate;

    public function __construct() {
        $this->registrationDateStart = new \DateTime();
        $this->registrationDateEnd = new \DateTime();
        $this->endOfYearDate = new \DateTime();
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

    /**
     * @return \DateTime
     */
    public function getRegistrationDateStart() {
        return $this->registrationDateStart;
    }

    /**
     * @param \DateTime $registrationDateStart
     */
    public function setRegistrationDateStart($registrationDateStart) {
        $registrationDateStartFormatted = explode('/', $registrationDateStart);
        $registrationDateStartFormatted = new \DateTime($registrationDateStartFormatted[2]. '-' . $registrationDateStartFormatted[1] . '-' . $registrationDateStartFormatted[0]);

        $this->registrationDateStart = $registrationDateStartFormatted;
    }

    /**
     * @return \DateTime
     */
    public function getRegistrationDateEnd() {
        return $this->registrationDateEnd;
    }

    /**
     * @param \DateTime $registrationDateEnd
     */
    public function setRegistrationDateEnd($registrationDateEnd) {
        $registrationDateEndFormatted = explode('/', $registrationDateEnd);
        $registrationDateEndFormatted = new \DateTime($registrationDateEndFormatted[2]. '-' . $registrationDateEndFormatted[1] . '-' . $registrationDateEndFormatted[0]);

        $this->registrationDateEnd = $registrationDateEndFormatted;
    }

    /**
     * @return mixed
     */
    public function getIsRegistrationOpen() {
        return $this->isRegistrationOpen;
    }

    /**
     * @param mixed $isRegistrationOpen
     */
    public function setIsRegistrationOpen($isRegistrationOpen) {
        $this->isRegistrationOpen = $isRegistrationOpen;
    }

    /**
     * @return mixed
     */
    public function getHeaderImage() {
        return $this->headerImage;
    }

    /**
     * @param mixed $headerImage
     */
    public function setHeaderImage($headerImage) {
        $this->headerImage = $headerImage;
    }

    /**
     * @return \DateTime
     */
    public function getEndOfYearDate() {
        return $this->endOfYearDate;
    }

    /**
     * @param \DateTime $endOfYearDate
     */
    public function setEndOfYearDate($endOfYearDate) {
        $endOfYearDateFormatted = explode('/', $endOfYearDate);
        $endOfYearDateFormatted = new \DateTime($endOfYearDateFormatted[2]. '-' . $endOfYearDateFormatted[1] . '-' . $endOfYearDateFormatted[0]);

        $this->endOfYearDate = $endOfYearDateFormatted;
    }
}