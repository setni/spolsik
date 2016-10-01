<?php

namespace SocialBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ActualityType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('artiste',null, [
                    'attr'  => ['class' => 'form-control']
                ]
            )
            ->add('titre',null, [
                    'attr'  => ['class' => 'form-control']
                ]
            )
            ->add('description', TextareaType::class , [
                    'attr'  => ['class' => 'form-control']
                ]
            )
            ->add('youtube' ,null, [
                    'attr'  => array('class' => 'form-control']
                ]
            )
           
            ->add('submit', SubmitType::class, [
                'label' => 'Go', 
                'attr'  => ['class' => 'btn btn-default pull-left']
                ]
            )
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SocialBundle\Entity\Actuality'
        ));
    }
}
