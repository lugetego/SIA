<?php

namespace Ccm\SiaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SesionesType extends AbstractType
{
     /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fecha', 'date',array(
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'label'=>'Fecha de la sesión',
                'required'=>false,
                'empty_value' => array('year' => 'Year', 'month' => 'Month', 'day' => 'Day')))
            ->add('name','text',array('label'=>'Nombre de la sesión'))
            ->add('actaConsejoFile', 'vich_file', array(
                'required' => false, 'label' => 'Acta de Consejo'
            ))
//            ->add('solicitudes')
            ->add('save', 'submit', array('label' => 'Guardar'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ccm\SiaBundle\Entity\Sesiones'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ccm_siabundle_sesiones';
    }
}
