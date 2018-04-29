<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 3/9/18
 * Time: 2:54 AM
 */

namespace AppBundle\Form;

use AppBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('username', TextType::class, array(
                'required' => true,
                'label' => 'Pseudo',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Pseudo',
                ],
                'error_bubbling' => true
            ))
            ->add('email', EmailType::class, array(
                'required' => true,
                'label' => 'Email',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Email',
                ],
                'error_bubbling' => true
            ))
            ->add('plainPassword', RepeatedType::class, array(
                'label' => 'Mot de passe',
                'type' => PasswordType::class,
                'options' => array(
                    'translation_domain' => 'FOSUserBundle',
                    'attr' => array(
                        'autocomplete' => 'new-password',
                    ),
                ),
                'first_options' => array(
                    'label' => 'form.password',
                    'attr' => [
                        'class' => 'form-control medium-input',
                        'placeholder' => 'Mot de passe'
                    ],
                ),
                'second_options' => array(
                    'label' => 'form.password_confirmation',
                    'attr' => [
                        'class' => 'form-control medium-input',
                        'placeholder' => 'Confirmer le mot de passe'
                    ],
                ),
                'invalid_message' => 'fos_user.password.mismatch',
            ))
            ->add('firstName', TextType::class, array(
                'required' => true,
                'label' => 'Prénom',
                'attr' => [
                    'class' => 'form-control medium-input',
                    'placeholder' => 'Prénom'
                ],
                'error_bubbling' => true
            ))
            ->add('lastName', TextType::class, array(
                'required' => true,
                'label' => 'Nom',
                'attr' => [
                    'class' => 'form-control medium-input',
                    'placeholder' => 'Nom'
                ],
                'error_bubbling' => true
            ))
            ->add('birthDate', TextType::class, array(
                'required' => true,
                'label' => 'Date de naissance',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Ex. 03/05/1980',
                    'data-inputmask' => "'alias': 'dd/mm/yyyy'",
                    'data-mask' => ""
                ],
                'error_bubbling' => true
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Créer le compte',
                'attr' => [
                    'class' => 'btn btn-primary btn-register-submit bold'
                ]
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class
        ));
    }
}