<?php

namespace Esprit\TrocBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\File\File;
class EventType extends AbstractType
{


    public  function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder
           ->add('nom')
           ->add('description')
           ->add('date')
           ->add('nombreplace')
           ->add('image', FileType::class, array('label' => 'Photo (png, jpeg)'))
       ;
    }



    public function getName()
    {
        return 'esprit_trocbundle_event';
    }


}
