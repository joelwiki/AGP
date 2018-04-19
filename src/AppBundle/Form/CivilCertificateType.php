<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 3/13/18
 * Time: 1:59 PM
 */

namespace AppBundle\Form;


use AppBundle\Entity\CivilCertificate;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CivilCertificateType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
            ->add('file', FileType::class, array(
                'label' => 'Attestation',
                'required' => true,
                'attr' => [
                    'class' => 'custom-file-input'
                ]
            ))
            ->add('submit', SubmitType::class, array(
                'attr' => [
                    'class' => 'btn btn-primary bold'
                ]
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => CivilCertificate::class
        ));
    }
}