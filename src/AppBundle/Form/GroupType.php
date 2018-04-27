<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 4/27/18
 * Time: 1:18 PM
 */

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use FOS\UserBundle\Form\Type\GroupFormType as BaseGroupFormType;


class GroupType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('name', TextType::class, array(
                'required' => false,
                'label' => 'Nom du groupe',
                'attr' => [
                    'class' => 'form-control medium-input'
                ],
                'error_bubbling' => true
            ))
            ->add('minAge', IntegerType::class, array(
                'required' => false,
                'label' => 'Age minimum',
                'attr' => [
                    'class' => 'form-control small-input',
                ],
                'error_bubbling' => true
            ))
            ->add('maxAge', IntegerType::class, array(
                'required' => false,
                'label' => 'Age maximum',
                'attr' => [
                    'class' => 'form-control small-input',
                ],
                'error_bubbling' => true
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Créer le groupe',
                'attr' => [
                    'class' => 'btn btn-primary bold mar-t-20'
                ]
            ))
        ;
    }

    public function getParent() {
        return BaseGroupFormType::class;
    }
}