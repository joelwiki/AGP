<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 3/15/18
 * Time: 1:04 PM
 */

namespace AppBundle\Form;


use AppBundle\Entity\Training;
use AppBundle\Entity\TrainingLocation;
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
                        return $trainingRef->getCategory();
                    },
                    'required' => true,
                ))
            ->add('trainingLocation', EntityType::class, array(
                'class' => TrainingLocation::class,
                'label' => 'Lieu d\'entraînement',
                'attr' => [
                    'class' => 'form-control select2'
                ],
                'choice_label' => function ($trainingLocation) {
                    return $trainingLocation->getCustomLocation();
                },
                'required' => true,
            ))
            ->add('date', TextType::class, array(
                'required' => true,
                'label' => 'Date',
                'attr' => [
                'class' => 'form-control datepicker medium-input-addon',
                'placeholder' => 'Ex. 03/05/1980',
                'data-inputmask' => "'alias': 'dd/mm/yyyy'",
                'data-mask' => ""
                ],
                'error_bubbling' => true
            ))
            ->add('info', TextareaType::class, array(
                'required' => false,
                'label' => 'Informations supplémentaires',
                'attr' => [
                    'class' => 'form-control medium-input'
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