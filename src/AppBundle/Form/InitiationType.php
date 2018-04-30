<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 28/03/18
 * Time: 16:10
 */

namespace AppBundle\Form;

use AppBundle\Entity\Initiation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InitiationType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('title', TextType::class, array(
                'required' => true,
                'label' => 'Titre',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Titre',
                ],
                'error_bubbling' => true
            ))
            ->add('content', TextareaType::class, array(
                'required' => true,
                'label' => 'Contenu',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Contenu',
                ],
                'error_bubbling' => true
            ))
            ->add('location', TextType::class, array(
                'required' => true,
                'label' => 'Lieu',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Lieu',
                ],
                'error_bubbling' => true
            ))
            ->add('date', TextType::class, array(
                'required' => true,
                'label' => 'Date',
                'attr' => [
                    'class' => 'form-control datepicker',
                    'placeholder' => 'jj/mm/aaaa'
                ]
            ))
            ->add('hourStart', TextType::class, array(
                'required' => true,
                'label' => 'Début',
                'attr' => [
                    'class' => 'form-control timepicker small-input'
                ],
                'error_bubbling' => true
            ))
            ->add('hourEnd', TextType::class, array(
                'required' => true,
                'label' => 'Fin',
                'attr' => [
                    'class' => 'form-control timepicker small-input'
                ],
                'error_bubbling' => true
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Ajouter l\'initiation',
                'attr' => [
                    'class' => 'btn btn-primary bold',
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
            'data_class' => Initiation::class
        ));
    }
}