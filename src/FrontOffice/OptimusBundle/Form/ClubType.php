<?php

namespace FrontOffice\OptimusBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ClubType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom','text',array('attr'=>array('class'=>'search-optimus','placeholder'=>'Entrer le nom du club')))
            ->add('file', 'file' ,array('attr'=>array('class'=>'btn btn-round btn-o search-optimus'),'required'=>False))
            ->add('dateCreation','date', array('attr'=>array('class' => 'search-optimus','placeholder'=>'date creation '),'format' => 'dd/MM/yyyy', 'widget' => "single_text", 'required' => False))
	
	
            ->add('discpline','text',array('attr'=>array('class'=>'search-optimus','placeholder'=>'Entrer la discpline'),'required' => False))
	->add('description','textarea',array('attr'=>array('class'=>'jqte-test','name'=> 'textarea','placeholder'=>'Entrer la description du votre évenement...'),'required' => False)) 
            ->add('adresse','text',array('attr'=>array('class'=>'search-optimus','placeholder'=>'Adresse', 'readonly'=>'readonly'),'required'=>True))
           
            ->add('fraisAdhesion','integer',array('attr'=>array('class'=>'form-control round sansBorder','placeholder'=>'Entrer les frais du club'),'required' => False))
            ->add('lat','hidden',array('attr'=>array('class'=>'search-optimus', )),array('required'=>true))
            ->add('lng','hidden',array('attr'=>array('class'=>'search-optimus',)),array('required'=>true))
            
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FrontOffice\OptimusBundle\Entity\Club'
           
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'frontoffice_optimusbundle_club';
    }
}
