<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 10/04/18
 * Time: 13:56
 */

namespace AppBundle\Form;


use AppBundle\Entity\TrainingLocation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrainingLocationType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

        /** @var TrainingLocation $trainingLocation */
        $trainingLocation = $options['data'];

        $builder
            ->add('customLocation', TextType::class, array(
                'label' => 'Description du lieu',
                'required' => true,
                'attr' => [
                    'class' => 'form-control medium-input'
                ]
            ))
            ->add('image', TrainingLocationImageType::class, array(
                'label' => 'Image du lieu',
                'data' => $trainingLocation->getImage()
            ))
            ->add('location', TextType::class, array(
                'required' => false,
                'label' => 'Lieu',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrer un lieu'
                ]
            ))
            ->add('lat', TextType::class, array(
                'required' => false,
                'label' => 'Latitude',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Latitude'
                ]
            ))
            ->add('lng', TextType::class, array(
                'required' => false,
                'label' => 'Longitude',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Longitude'
                ]
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Ajouter le lieu',
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
            'data_class' => TrainingLocation::class
        ));
    }
}