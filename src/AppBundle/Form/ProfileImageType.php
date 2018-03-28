<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 3/8/18
 * Time: 5:07 PM
 */

namespace AppBundle\Form;


use AppBundle\Entity\UserImage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileImageType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file', FileType::class, array(
                'label' => false,
                'attr' => [
                    'class' => 'custom-file-input',
                    'data-toggle' => 'modal',
                    'data-target' => '#cropp-image'
                ],
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => UserImage::class
        ));
    }
}