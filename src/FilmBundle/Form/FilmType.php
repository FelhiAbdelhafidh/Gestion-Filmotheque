<?php

namespace FilmBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilmType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('titre',TextType::class)
                ->add('description', TextareaType::class)
                ->add('categorie',EntityType::class,array(
                    'class'=>'FilmBundle:Categorie',
                    'choice_label'=>'nom'
                ))
                ->add('acteurs',EntityType::class,array(
                    'class'=>'FilmBundle:Acteur',
                    'choice_label'=>'NomPrenom',
                    'multiple'=>true
                ))
                ->add('file');
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FilmBundle\Entity\Film'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'filmbundle_film';
    }


}
