<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 3/9/18
 * Time: 5:15 PM
 */

namespace AppBundle\Form;


use AppBundle\Entity\MedicalCertificate;
use AppBundle\Entity\MedicalCertificateImage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MedicalCertificateType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

        /** @var MedicalCertificate $medicalCertificate */
        $medicalCertificate = $options['data'];

        $builder
            ->add('image', MedicalCertificateImageType::class, array(
                'required' => false,
                'label' => 'Certificat médical',
                'data' => $medicalCertificate->getImage(),
                'error_bubbling' => true
            ))
            ->add('doctorName', TextType::class, array(
                'required' => false,
                'label' => 'Nom du médecin',
                'attr' => [
                    'class' => 'form-control medium-input',
                ],
                'error_bubbling' => true
            ))
            ->add('doctorPhone', TelType::class, array(
                'required' => false,
                'label' => 'Numéro du médecin',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Ex. 01 23 45 67 89',
                    'data-inputmask' => "'mask': ['99 99 99 99 99', '99 99 99 99 99']",
                    'data-mask' => "",
                    'minlength' => 14,
                    'maxlength' => 14
                ],
                'error_bubbling' => true
            ))
            ->add('date', TextType::class, array(
                'required' => false,
                'label' => 'Date du dernier certificat',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Ex. 03/05/1980',
                    'data-inputmask' => "'alias': 'dd/mm/yyyy'",
                    'data-mask' => ""
                ],
                'error_bubbling' => true
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => MedicalCertificate::class
        ));
    }
}