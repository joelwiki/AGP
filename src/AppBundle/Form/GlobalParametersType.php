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
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GlobalParametersType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('membershipFee', IntegerType::class, array(
                'required' => true,
                'label' => 'Montant de la cotisation (€)',
                'attr' => [
                    'class' => 'form-control small-input',
                ],
                'error_bubbling' => true
            ))
            ->add('themeColor', ChoiceType::class, array(
                'label' => 'Couleur du thème',
                'choices' => [
                    'Thème sombre' => array(
                        'Bleu' => 'blue',
                        'Rouge' => 'red',
                        'Vert' => 'green',
                        'Violet' => 'purple',
                        'Jaune' => 'yellow',
                        'Blanc' => 'black'
                    ),
                    'Thème clair' => array(
                        'Bleu' => 'blue-light',
                        'Rouge' => 'red-light',
                        'Vert' => 'green-light',
                        'Violet' => 'purple-light',
                        'Jaune' => 'yellow-light',
                        'Blanc' => 'black-light'
                    ),
                ],
                'attr' => [
                    'class' => 'themeColor'
                ]
            ))
            ->add('siteName', TextType::class, array(
                'label' => 'Nom du site',
                'attr' => [
                    'class' => 'form-control medium-input'
                ]
            ))
            ->add('registrationDateStart', TextType::class, array(
                'required' => true,
                'label' => 'Début des inscriptions',
                'attr' => [
                    'class' => 'form-control datepicker medium-input-addon',
                    'placeholder' => 'jj/mm/aaaa'
                ]
            ))
            ->add('registrationDateEnd', TextType::class, array(
                'required' => true,
                'label' => 'Fin des inscriptions',
                'attr' => [
                    'class' => 'form-control datepicker medium-input-addon',
                    'placeholder' => 'jj/mm/aaaa'
                ]
            ))
            ->add('headerImage', HeaderImageType::class, array(
                'required' => true,
                'label' => 'Image d\'en-tête',
                'error_bubbling' => true,
                'data' => $options['data']->getHeaderImage()
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Valider les modifications',
                'attr' => [
                    'class' => 'btn btn-primary bold mar-t-20'
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
            'data_class' => GlobalParameters::class
        ));
    }
}