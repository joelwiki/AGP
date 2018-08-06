<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 05/04/18
 * Time: 14:56
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\Group as BaseGroup;

/**
 * @ORM\Entity
 * @ORM\Table(name="agp_group")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GroupRepository")
 */
class Group extends BaseGroup {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $minAge;

    /**
     * @ORM\Column(type="integer")
     */
    private $maxAge;

    /**
     * @ORM\Column(type="boolean")
     */
    private $enabled;

    public function __construct() {
        $this->enabled = 1;
    }

    public function __toString () {
        return $this->getMinAge() . '-' . $this->getMaxAge() . ' ans';
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
    public function getMinAge() {
        return $this->minAge;
    }

    /**
     * @param mixed $minAge
     */
    public function setMinAge($minAge) {
        $this->minAge = $minAge;
    }

    /**
     * @return mixed
     */
    public function getMaxAge() {
        return $this->maxAge;
    }

    /**
     * @param mixed $maxAge
     */
    public function setMaxAge($maxAge) {
        $this->maxAge = $maxAge;
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
}
