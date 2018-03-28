<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 3/7/18
 * Time: 3:44 PM
 */

namespace AppBundle\Form;

use AppBundle\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('title', TextType::class, array(
                'required' => true,
                'label' => 'Titre',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Titre de l\'article',
                ],
                'error_bubbling' => true
            ))
            ->add('content', TextareaType::class, array(
                'required' => true,
                'label' => 'Contenu',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Contenu de l\'article',
                ],
                'error_bubbling' => true
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Publier l\'article',
                'attr' => [
                    'class' => 'btn btn-primary bold',
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
            'data_class' => Article::class
        ));
    }
}