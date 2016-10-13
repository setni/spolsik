<?php
// src/MainBundle/Form/RegistrationType.php

namespace MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username',null, [
                    'attr'  => ['class' => 'form-control']
                ]
            )
            ->add('password',null, [
                    'attr'  => ['class' => 'form-control']
                ]
            )
        ;
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\UsernameFormType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_login';
    }

    public function getName()
    {
        return $this->getBlockPrefix();
    }
}