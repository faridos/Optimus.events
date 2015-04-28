<?php

namespace FrontOffice\OptimusBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class EventPhotoType extends AbstractType
{
     public function buildForm(FormBuilderInterface $builder, array $options)
    {
         $builder
                   ->add('file', 'file' ,array('attr'=>array('class'=>'file','multiple data-show-upload'=>'false','data-show-caption'=>'false', 'data-show-remove'=>'false')));
         
     }
      /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FrontOffice\OptimusBundle\Entity\Event'
        ));
    }

    /**
     * @return string
     */
    

    public function getName() {
         return 'frontoffice_userbundle_event';
    }

    //put your code here
}
