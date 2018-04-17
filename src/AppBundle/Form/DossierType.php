<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 3/9/18
 * Time: 2:20 PM
 */

namespace AppBundle\Form;

use AppBundle\Entity\Dossier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DossierType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('firstName', TextType::class, array(
                'required' => true,
                'label' => 'Prénom',
                'attr' => [
                    'class' => 'form-control',
                ],
                'error_bubbling' => true
            ))
            ->add('lastName', TextType::class, array(
                'required' => true,
                'label' => 'Nom',
                'attr' => [
                    'class' => 'form-control',
                ],
                'error_bubbling' => true
            ))
            ->add('birthDate', TextType::class, array(
                'required' => true,
                'label' => 'Date de naissance',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Ex. 03/05/1980',
                    'data-inputmask' => "'alias': 'dd/mm/yyyy'",
                    'data-mask' => ""
                ],
                'error_bubbling' => true
            ))
            ->add('sex', ChoiceType::class, array(
                'required' => true,
                'label' => 'Sexe',
                'attr' => [
                    'class' => 'form-control small-input'
                ],
                'choices' => array(
                    'Homme' => 'Homme',
                    'Femme' => 'Femme'
                ),
                'error_bubbling' => true
            ))
            ->add('shirtSize', ChoiceType::class, array(
                'required' => true,
                'label' => 'Taille de T-shirt',
                'attr' => [
                    'placeholder' => 'Taille de T-shirt',
                    'class' => 'form-control small-input'
                ],
                'choices' => array(
                    'XS' => 'XS',
                    'S' => 'S',
                    'M' => 'M',
                    'L' => 'L',
                    'XL' => 'XL',
                    'XXL' => 'XXL',
                ),
                'error_bubbling' => true
            ))
            ->add('paymentType', ChoiceType::class, array(
                'required' => true,
                'label' => 'Type de paiement',
                'attr' => [
                    'class' => 'form-control medium-input'
                ],
                'choices' => array(
                    'Espèces' => 'Especes',
                    'Chèque' => 'Cheque',
                    'Carte bancaire' => 'Carte'
                ),
                'error_bubbling' => true
            ))
            ->add('street', TextType::class, array(
                'required' => true,
                'label' => 'Numéro et nom de rue',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Ex. 1 rue Victor Hugo',
                ],
                'error_bubbling' => true
            ))
            ->add('zipCode', TextType::class, array(
                'required' => true,
                'label' => 'Code postal',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Ex. 38000',
                    'minlength' => 5,
                    'maxlength' => 5
                ],
                'error_bubbling' => true
            ))
            ->add('city', TextType::class, array(
                'required' => true,
                'label' => 'Ville',
                'attr' => [
                    'class' => 'form-control',
                ],
                'error_bubbling' => true
            ))
            ->add('email', EmailType::class, array(
                'required' => true,
                'label' => 'Adresse email',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Ex. email@gmail.fr'
                ],
                'error_bubbling' => true
            ))
            ->add('phone', TelType::class, array(
                'required' => false,
                'label' => 'Numéro de téléphone',
                'attr' => [
                    'class' => 'form-control medium-input',
                    'placeholder' => 'Ex. 01 23 45 67 89',
                    'data-inputmask' => "'mask': ['99 99 99 99 99', '99 99 99 99 99']",
                    'data-mask' => "",
                    'minlength' => 14,
                    'maxlength' => 14
                ],
                'trim' => true,
                'error_bubbling' => true
            ))
            ->add('emergencyContactFirstName', TextType::class, array(
                'required' => true,
                'label' => 'Prénom du contact',
                'attr' => [
                    'class' => 'form-control',
                ],
                'error_bubbling' => true
            ))
            ->add('emergencyContactLastName', TextType::class, array(
                'required' => true,
                'label' => 'Nom du contact',
                'attr' => [
                    'class' => 'form-control',
                ],
                'error_bubbling' => true
            ))
            ->add('emergencyContactPhone', TelType::class, array(
                'required' => true,
                'label' => 'Téléphone du contact',
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
            ->add('emergencyContactRelation', ChoiceType::class, array(
                'required' => true,
                'label' => 'Relation du contact',
                'attr' => [
                    'class' => 'form-control',
                ],
                'choices' => [
                    'Père' => 'Pere',
                    'Mère' => 'Mere',
                    'Grand-père' => 'Grand-pere',
                    'Grand-mère' => 'Grand-mère',
                    'Frère' => 'Frere',
                    'Soeur' => 'Soeur',
                    'Conjoint' => 'Conjoint',
                    'Conjointe' => 'Conjointe',
                    'Autre' => 'Autre'
                ],
                'error_bubbling' => true
            ))
            ->add('emergencyContactTwoFirstName', TextType::class, array(
                'required' => false,
                'label' => 'Prénom du contact',
                'attr' => [
                    'class' => 'form-control',
                ],
                'error_bubbling' => true
            ))
            ->add('emergencyContactTwoLastName', TextType::class, array(
                'required' => false,
                'label' => 'Nom du contact',
                'attr' => [
                    'class' => 'form-control',
                ],
                'error_bubbling' => true
            ))
            ->add('emergencyContactTwoPhone', TelType::class, array(
                'required' => false,
                'label' => 'Téléphone du contact',
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
            ->add('emergencyContactTwoRelation', ChoiceType::class, array(
                'required' => true,
                'label' => 'Relation du contact',
                'attr' => [
                    'class' => 'form-control',
                ],
                'choices' => [
                    'Parent' => 'Parent',
                    'Frère/Soeur' => 'Frère/Soeur',
                    'Grand-parent' => 'Grand-parent',
                    'Oncle/Tante' => 'Oncle/Tante',
                    'Cousin/Cousine' => 'Cousine/Cousine',
                    'Tuteur légal' => 'Tuteur légal',
                    'Ami' => 'Ami'
                ],
                'error_bubbling' => true
            ))
            ->add('parentalAuthorization', CheckboxType::class, array(
                'required' => false,
                'label' => 'Autorisation parentale',
                'error_bubbling' => true
            ))
            ->add('imageRight', CheckboxType::class, array(
                'required' => false,
                'label' => 'Droit à l\'image',
                'error_bubbling' => true
            ))
            ->add('responsability', CheckboxType::class, array(
                'required' => true,
                'label' => 'Responsabilité',
                'error_bubbling' => true
            ))
            ->add('termsOfAgreement', CheckboxType::class, array(
                'required' => true,
                'label' => 'Conditions d\'utilisation',
                'error_bubbling' => true
            ))
            ->add('medicalCertificate', MedicalCertificateType::class, array(
                'required' => true,
                'label' => 'Certificat médical',
                'error_bubbling' => true,
                'data' => $options['data']->getMedicalCertificate()
            ))
            ->add('civilLiabilityCertificate', CivilCertificateType::class, array(
                'required' => true,
                'label' => 'Attestation civile',
                'error_bubbling' => true,
                'data' => $options['data']->getCivilLiabilityCertificate()
            ))
            ->add('fpkNumber', TextType::class, array(
                'required' => false,
                'label' => 'N° d\'adhérent FPK',
                'error_bubbling' => true,
                'attr' => [
                    'class' => 'form-control small-input pk-input',
                    'placeholder' => 'PKxxxxxxx',
                    'minlength' => 9,
                    'maxlength' => 9
                ]
            ))
            ->add('submit', SubmitType::class, array(
                'attr' => [
                    'class' => 'btn btn-primary bold'
                ],
                'label' => 'Créer le dossier'
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Dossier::class
        ));
    }
}