<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 26/03/18
 * Time: 23:23
 */

namespace AppBundle\Services;


use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Role\Role;
use Symfony\Component\Security\Core\Role\RoleHierarchyInterface;

class RoleService {
    private $roleHierarchy;

    /**
     * RoleService constructor.
     * @param RoleHierarchyInterface $roleHierarchy
     */
    public function __construct(RoleHierarchyInterface $roleHierarchy) {
        $this->roleHierarchy = $roleHierarchy;
    }

    public function isGranted($role, User $user) {
        $role = new Role($role);

        foreach ($user->getRoles() as $userRole) {
            if (in_array($role, $this->roleHierarchy->getReachableRoles(array(new Role($userRole))))) {
                return true;
            }
        }

        return false;
    }

    /**
     * Provide roles choices by connected user
     *
     * @param $user
     */
    public function getRolesChoices($user) {
        $roles = [
            'ROLE_SUPER_ADMIN' => 'ROLE_SUPER_ADMIN',
            'ROLE_ADMIN' => 'ROLE_ADMIN',
            'ROLE_PRESIDENT' => 'ROLE_PRESIDENT',
            'ROLE_MEMBRE_BUREAU' => 'ROLE_MEMBRE_BUREAU',
            'ROLE_MEMBRE_CA' => 'ROLE_MEMBRE_CA',
            'ROLE_ENCADRANT' => 'ROLE_ENCADRANT',
            'ROLE_AIDE_ENCADRANT' => 'ROLE_AIDE_ENCADRANT',
            'ROLE_MEMBRE' => 'ROLE_MEMBRE'
        ];

        $highestRole = $this->getHighestRole($user->getRoles());

        foreach ($roles as $role) {
            if ($this->isGranted($role, $user) && $role != $highestRole) {
                $choices[$role] = $role;
            }
        }
    }

    /**
     * We provide an array of roles and get highest one
     *
     * RoleHierarchy is used to get how many roles a determinate role have in the hierarchy.
     * Get the role who have more roles (count) in the hierarchy.
     *
     * @param array $roles
     *
     * @return mixed|null
     */
    public function getHighestRole(array $roles) {
        /** Count how many roles have a role in his hierarchy @var int $countRoles */
        $countRoles = 0;
        /** Store highest role @var string $highestRole */
        $highestRole = null;

        /** Process each role @var string $role */
        foreach ($roles as $role) {
            /** If the count of hierarchy roles is upper than the stored one, this role take over */
            if ($countRoles < $this->roleHierarchy->getReachableRoles(array(new Role($role)))) {
                $countRoles = $this->roleHierarchy->getReachableRoles(array(new Role($role)));
                $highestRole = $role;
            }

        }

        /** Return the role */
        return $highestRole;
    }
}