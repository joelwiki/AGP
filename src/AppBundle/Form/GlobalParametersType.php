<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 10/04/18
 * Time: 17:16
 */

namespace AppBundle\Form;


use AppBundle\Entity\GlobalParameters;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GlobalParametersType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('membershipFee', IntegerType::class, array(
                'required' => true,
                'label' => 'Montant de la cotisation',
                'attr' => [
                    'class' => 'form-control',
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
            'data_class' => GlobalParameters::class
        ));
    }
}