<?php

namespace Ccm\SiaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProyectoType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numero')
            ->add('nombre')
            ->add('academico')
            ->add('save', 'submit', array('label' => 'Guardar'))

        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ccm\SiaBundle\Entity\Proyecto'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ccm_siabundle_proyecto';
    }
}
