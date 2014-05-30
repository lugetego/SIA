<?php

namespace Ccm\SiaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Ccm\SiaBundle\Form\FinanciamientoType;


class SolicitudType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tipo', 'choice', array('empty_value' => 'Choose an option','choices'=>array('licencia'=>'Licencia','comision'=>'Comision','visitante'=>'Visitante')))
            ->add('academico')
            ->add('sesion')
            ->add('pais')
            ->add('ciudad')
            ->add('universidad')
            ->add('profesor')
            ->add('actividad')
            ->add('proposito')
            ->add('proyecto')
            ->add('inicio', 'date',array('widget' => 'single_text', 'format' => 'yyyy-MM-dd'))
            ->add('fin', 'date',array('widget' => 'single_text', 'format' => 'yyyy-MM-dd'))
            // ->add('inicio','date',array('widget' => 'single_text','format' => 'yyyy-MM-dd', 'attr' => array('class'=>'form-control', 'datepicker-popup'=> 'yyyy-MM-dd','ng-model'=>'dt',
            //'is-open'=>'opened', 'min-date'=>'minDate', 'max-date'=>"'2014-12-31'", 'datepicker-options'=>'dateOptions', 'ng-required'=>'true', 'close-text'=>'Close' )))
            //->add('fin','date',array('widget' => 'single_text','format' => 'yyyy-MM-dd', 'attr' => array('class'=>'form-control', 'datepicker-popup'=> 'yyyy-MM-dd','ng-model'=>'dt',
            //          'is-open'=>'opened', 'min-date'=>'minDate', 'max-date'=>"'2014-12-31'", 'datepicker-options'=>'dateOptions', 'ng-required'=>'true', 'close-text'=>'Close' )))
            ->add('trabajo')
            ->add('financiamiento', 'collection', array(
                'type' => new FinanciamientoType(),
                'allow_add'    => true,
            ));

        //   ->add('sesion', 'entity', array(
        //       'class' => 'CcmSiaBundle:Sesiones',
        //       'query_builder' => function(\Doctrine\ORM\EntityRepository  $er) {
        //               return $er->createQueryBuilder('u')
        //                   ->orderBy('u.id', 'DESC');},))


        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ccm\SiaBundle\Entity\Solicitud',
            'cascade_validation' => true,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ccm_siabundle_solicitud';
    }
}
