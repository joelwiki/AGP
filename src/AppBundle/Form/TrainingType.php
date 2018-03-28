<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 3/15/18
 * Time: 1:04 PM
 */

namespace AppBundle\Form;


use AppBundle\Entity\Training;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\TrainingRef;

class TrainingType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

        /** @var Training $training */
        $training = $options['data'];

        $builder
            ->add('trainingType', EntityType::class, array(
                    'class' => TrainingRef::class,
                    'label' => 'Type d\'entraînement',
                    'attr' => [
                        'class' => 'form-control select2 medium-input'
                    ],
                    'choice_label' => function ($trainingRef) {
                        return $trainingRef->getWeekDay() . ' ' . $trainingRef->getCategoryStart() . '-' . $trainingRef->getCategoryEnd() . ' ans';
                    },
                    'required' => true,
                ))
            ->add('date', TextType::class, array(
                'required' => true,
                'label' => 'Date',
                'attr' => [
                    'class' => 'form-control datepicker medium-input-addon',
                    'placeholder' => 'jj/mm/aaaa'
                ]
            ))
            ->add('location', TextType::class, array(
                'required' => true,
                'label' => 'Lieu',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrer un lieu'
                ]
            ))
            ->add('lat', TextType::class, array(
                'required' => true,
                'label' => 'Latitude',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Latitude'
                ]
            ))
            ->add('lng', TextType::class, array(
                'required' => true,
                'label' => 'Longitude',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Longitude'
                ]
            ))
            ->add('info', TextareaType::class, array(
                'required' => false,
                'label' => 'Informations supplémentaires',
                'attr' => [
                    'class' => 'form-control medium-input'
                ]
            ))
            ->add('image', TrainingImageType::class, array(
                'label' => 'Image du lieu',
                'data' => $training->getImage()
            ))
            ->add('limitedPlaces', CheckboxType::class, array(
                'required' => false,
                'label' => 'Places limitées'
            ))
            ->add('places', IntegerType::class, array(
                'required' => false,
                'label' => 'Places',
                'attr' => [
                    'class' => 'form-control medium-input',
                    'min' => 2,
                    'max' => 100
                ]
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Créer l\'entraînement',
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
            'data_class' => Training::class
        ));
    }
}