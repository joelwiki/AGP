<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 3/10/18
 * Time: 6:26 PM
 */

namespace AppBundle\Form;


use AppBundle\Entity\MedicalCertificateImage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MedicalCertificateImageType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
            ->add('file', FileType::class, array(
                'label' => false,
                'required' => false,
                'attr' => [
                    'class' => 'custom-file-input'
                ]
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => MedicalCertificateImage::class
        ));
    }
}