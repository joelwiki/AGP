<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 3/8/18
 * Time: 5:06 PM
 */

namespace AppBundle\Form;

use AppBundle\Entity\Group;
use AppBundle\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TelType;

use FOS\UserBundle\Form\Type\ProfileFormType as BaseProfileFormType;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class ProfileType extends AbstractType {

    private $currentUser;
    private $tokenStorage;
    private $container;

    public function __construct(TokenStorage $tokenStorage, ContainerInterface $container) {
        $this->tokenStorage = $tokenStorage;
        $this->currentUser = $this->tokenStorage->getToken()->getUser();
        $this->container = $container;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('firstName', TextType::class, array(
                'required' => false,
                'label' => 'Prénom',
                'attr' => [
                    'class' => 'form-control medium-input',
                    'placeholder' => 'Prénom',
                ],
                'error_bubbling' => true
            ))
            ->add('lastName', TextType::class, array(
                'required' => false,
                'label' => 'Nom',
                'attr' => [
                    'class' => 'form-control medium-input',
                    'placeholder' => 'Nom',
                ],
                'error_bubbling' => true
            ))
            ->add('city', TextType::class, array(
                'required' => false,
                'label' => 'Ville',
                'attr' => [
                    'class' => 'form-control medium-input',
                    'placeholder' => 'Ville',
                ],
                'error_bubbling' => true
            ))
            ->add('phone', TelType::class, array(
                'required' => false,
                'label' => 'Téléphone',
                'attr' => [
                    'class' => 'form-control medium-input',
                    'placeholder' => '0123456789',
                ],
                'error_bubbling' => true
            ))
            ->add('birthdate', BirthdayType::class, array(
                'required' => false,
                'label' => 'Date de naissance',
                'attr' => [
                    'class' => '',
                    'placeholder' => 'Date de naissance',
                ],
                'error_bubbling' => true
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Modifier le profil',
                'attr' => [
                    'class' => 'btn btn-primary bold',
                ]
            ))
        ;

        /** @var User $user */
        $user = $options['data'];

        if ($user->getId() !== $this->currentUser->getId() && $this->container->get('security.authorization_checker')->isGranted('ROLE_PRESIDENT')) {
            $builder
                ->add('group', EntityType::class, array(
                    'class' => Group::class,
                    'choice_label' => function ($group) {
                        return $group->getName() . ' ans';
                    },
                    'required' => false,
                    'label' => 'Groupe',
                    'attr' => [
                        'class' => '',
                    ],
                    'error_bubbling' => true
                ))
                ->add('roles', ChoiceType::class, array(
                    'required' => true,
                    'attr' => [
                        'class' => 'form-control'
                    ],
                    'label' => 'Rôles',
                    'choices' => [
                        'ROLE_ADMIN' => 'ROLE_ADMIN',
                        'ROLE_PRESIDENT' => 'ROLE_PRESIDENT',
                        'ROLE_MEMBRE_CA' => 'ROLE_MEMBRE_CA',
                        'ROLE_ENCADRANT' => 'ROLE_ENCADRANT',
                        'ROLE_AIDE_ENCADRANT' => 'ROLE_AIDE_ENCADRANT',
                        'ROLE_MEMBRE' => 'ROLE_MEMBRE',
                        'ROLE_USER' => 'ROLE_USER'
                    ],
                    'multiple' => true,
                ))
            ;
        }
    }

    public function getParent() {
        return BaseProfileFormType::class;
    }
}