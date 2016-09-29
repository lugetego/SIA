<?php

namespace Ccm\SiaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class FinanciamientoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('ccm', 'integer')
            ->add('conacyt', 'integer')
            ->add('papiit', 'integer')
            ->add('otro', 'integer')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
        'data_class' => 'Ccm\SiaBundle\Entity\Financiamiento',
        ));
    }

    /**
     * @return string
    */
    public function getName()
    {
        return 'ccm_siabundle_financiamiento';
    }
}