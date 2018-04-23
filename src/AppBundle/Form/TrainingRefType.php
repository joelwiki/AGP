<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 3/14/18
 * Time: 6:54 PM
 */

namespace AppBundle\Form;

use AppBundle\Entity\Group;
use AppBundle\Entity\TrainingRef;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrainingRefType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('category', EntityType::class, array(
                'class' => Group::class,
                'label' => 'Catégorie',
                'attr' => [
                    'class' => 'form-control select2 medium-input'
                ],
                'required' => true,
            ))
            ->add('type', ChoiceType::class, array(
                'required' => true,
                'label' => 'Type',
                'attr' => [
                    'class' => 'form-control select2 small-input'
                ],
                'choices' => array(
                    'Mixte' => 'Mixte',
                    'Féminin' => 'Féminin'
                ),
                'error_bubbling' => true
            ))
            ->add('weekDay', ChoiceType::class, array(
                'required' => true,
                'label' => 'Jour de la semaine',
                'attr' => [
                    'class' => 'form-control small-input'
                ],
                'choices' => array(
                    'Lundi' => 'Lundi',
                    'Mardi' => 'Mardi',
                    'Mercredi' => 'Mercredi',
                    'Jeudi' => 'Jeudi',
                    'Vendredi' => 'Vendredi',
                    'Samedi' => 'Samedi',
                    'Dimanche' => 'Dimanche',
                ),
                'error_bubbling' => true
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
                'label' => 'Créer le créneau horaire',
                'attr' => [
                    'class' => 'btn btn-primary bold'
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
            'data_class' => TrainingRef::class
        ));
    }
}