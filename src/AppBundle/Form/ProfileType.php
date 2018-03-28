<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 3/8/18
 * Time: 5:06 PM
 */

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TelType;

use FOS\UserBundle\Form\Type\ProfileFormType as BaseProfileFormType;

class ProfileType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('firstName', TextType::class, array(
                'required' => false,
                'label' => 'Prénom',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Prénom',
                ],
                'error_bubbling' => true
            ))
            ->add('lastName', TextType::class, array(
                'required' => false,
                'label' => 'Nom',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Nom',
                ],
                'error_bubbling' => true
            ))
            ->add('city', TextType::class, array(
                'required' => false,
                'label' => 'Ville',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Ville',
                ],
                'error_bubbling' => true
            ))
            ->add('phone', TelType::class, array(
                'required' => false,
                'label' => 'Téléphone',
                'attr' => [
                    'class' => 'form-control',
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
            ->add('image', ProfileImageType::class, array(
                'required' => false,
                'label' => 'Image',
                'attr' => [
                    'class' => 'edit-profile-avatar-input',
                    'placeholder' => 'Image',
                ],
                'error_bubbling' => true
            ))
        ;
    }

    public function getParent() {
        return BaseProfileFormType::class;
    }
}