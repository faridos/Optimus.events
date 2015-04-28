<?php

namespace FrontOffice\UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;
use libphonenumber\PhoneNumberFormat;

class RegistrationFormType extends BaseType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('nom', 'text', array('attr' => array('class' => 'form-control')))
                ->add('prenom', 'text', array('attr' => array('class' => 'form-control')))
                ->add('file', 'file', array('attr' => array('class' => 'form-control'), 'required' => False))
                  ->add('dateNaissance', 'date' , array('attr'=>array('class' => 'form-control','placeholder'=>'Date de naissance'),'format' => 'dd/MM/yyyy', 'widget' => "single_text", 'required' => False))
                ->add('sexe', 'choice', array('choices' => array('H' => 'Homme', 'F' => 'Femme'), 'attr' => array('class' => 'form-control')))
                ->add('profil', 'choice', array('choices' => array('Sportif' => 'Sportif', 'Entraineur' => 'Entraineur')))
                ->add('adresse', 'textarea', array('attr' => array('class' => 'form-control'), 'required' => False))
                ->add('tel', 'text', array('required' => false,'attr' => array('class' => 'form-control'), 'required' => False))
                ->add('email', 'email', array('label' => 'form.email', 'translation_domain' => 'FOSUserBundle', 'attr' => array('class' => 'form-control')))
                ->add('username', null, array('label' => 'form.username', 'translation_domain' => 'FOSUserBundle', 'attr' => array('class' => 'form-control')))
                ->add('plainPassword', 'repeated', array(
                    'type' => 'password',
                    'options' => array('translation_domain' => 'FOSUserBundle'),
                    'first_options' => array('label' => 'form.password', 'max_length' => 20, 'attr' => array('class' => 'form-control')),
                    'second_options' => array('label' => 'form.password_confirmation', 'attr' => array('class' => 'form-control')),
                    'invalid_message' => 'fos_user.password.mismatch',
                ))
                ->add('lat', 'number', array('attr' => array('class' => 'form-control')))
                ->add('lng', 'number', array('attr' => array('class' => 'form-control')))
        ;
    }

    public function getName() {
        return 'frontoffice_user_registration';
    }

    public function getParent() {
        return 'fos_user_registration';
    }

}
