<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 3/13/18
 * Time: 1:59 PM
 */

namespace AppBundle\Form;


use AppBundle\Entity\GlobalParameters;
use AppBundle\Entity\HeaderImage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HeaderImageType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

        /** @var GlobalParameters $global */
        $global = $options['data'];

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
            'data_class' => HeaderImage::class
        ));
    }
}