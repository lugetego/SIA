<?php

namespace Ccm\SiaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AcademicoType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name','text',array(
                'required'=>false,
                'label'=>'Nombre'))
            ->add('apellido','text',array(
                'required'=>false,
                'label'=>'Apellido(s)'))
            ->add('nacimiento', 'date',array(
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'label'=>'Fecha de nacimiento',
                'required'=>false,
                'empty_value' => array('year' => 'Year', 'month' => 'Month', 'day' => 'Day')))
            ->add('rfc','text',array(
                'required'=>false,
                'label'=>'RFC'))
            ->add('user',null,array(
                'label'=>'Usuario',
                'required'=>false))
            ->add('dias','text',array('required'=>false,'label'=>'Días de licencia'))
            ->add('save', 'submit', array('label' => 'Guardar'))

        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ccm\SiaBundle\Entity\Academico'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ccm_siabundle_academico';
    }
}
