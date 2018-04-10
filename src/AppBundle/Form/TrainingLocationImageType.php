<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 3/19/18
 * Time: 4:46 PM
 */

namespace AppBundle\Form;


use AppBundle\Entity\TrainingLocationImage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrainingLocationImageType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

        /** @var TrainingLocationImage $trainingImage */
        $trainingImage = $options['data'];

        $builder
            ->add('file', FileType::class, array(
                'label' => false,
                'required' => $trainingImage->getId() ? false : true,
                'attr' => [
                    'class' => 'custom-file-input'
                ]
            ));
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => TrainingLocationImage::class
        ));
    }
}