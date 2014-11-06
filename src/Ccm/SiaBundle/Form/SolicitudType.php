<?php

namespace Ccm\SiaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Ccm\SiaBundle\Form\FinanciamientoType;
use Ccm\SiaBundle\Entity\Academico;


class SolicitudType extends AbstractType
{

    private $securityContext;

    public function __construct(SecurityContext $securityContext)
    {
        $this->securityContext = $securityContext;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $this->securityContext->getToken()->getUser();

        if (!$user) {
            throw new \LogicException(
                'The FriendMessageFormType cannot be used without an authenticated user!'
            );
        }

        $builder
            ->add('tipo', 'choice', array(
                'empty_value' => 'Seleccionar',
                'required'=>true,
                'choices'=>array(
                    'licencia'=>'Licencia',
                    'comision'=>'Comision',
                )));

        if ( false === $this->securityContext->isGranted('ROLE_ADMIN') ) {

            $builder
                ->add('academico', 'entity', array(
                    'class' => 'Ccm\SiaBundle\Entity\Academico',
                    'label' => 'Académico',
                    'empty_value' => 'Seleccionar',
                    'required'=>false,
                    'query_builder'=> function(\Doctrine\ORM\EntityRepository  $er) use ($user) {
                        return $er->createQueryBuilder('q')
                                ->select('r')
                                ->from('Ccm\SiaBundle\Entity\Academico', 'r')
                                ->leftjoin('r.user','a')
                                ->where('a.id = :id')
                                ->setParameter('id', $user->getId())
                                ;}, ))

                ->add('proyecto', 'entity', array(
                    'class' => 'Ccm\SiaBundle\Entity\Proyecto',
                    'label' => 'Proyecto',
                    'empty_value' => 'Seleccionar',
                    'required'=>false,
                    'query_builder'=> function(\Doctrine\ORM\EntityRepository  $er) use ($user) {
                        return $er->createQueryBuilder('q')
                                ->select('r')
                                ->from('Ccm\SiaBundle\Entity\Proyecto', 'r')
                                ->leftjoin('r.academico','a')
                                ->where('a.id = :id')
                                ->setParameter('id', $user->getAcademico())
                                ;}, ));
        }

        else {

            $builder
                ->add('academico',null,array(
                    'required'=>false,
                    'label'=>'Académico',
                    'empty_value' => 'Seleccionar'))
                ->add('proyecto', 'entity', array(
                    'required'=>false,
                    'empty_value' => 'Seleccionar',
                    'class' => 'Ccm\SiaBundle\Entity\Proyecto',
                    'query_builder'=> function(\Doctrine\ORM\EntityRepository  $er) use ($user) {
                         return $er->createQueryBuilder('q')
                                 ->select('r')
                                 ->from('Ccm\SiaBundle\Entity\Proyecto', 'r')
                                 ;}, ));
        }

            $builder
                ->add('sesion',null,array(
                    'required'=>false,
                    'empty_value' => 'Seleccionar',
                    'label'=> 'Sesión de consejo'))
                ->add('pais','text',array('required'=>false,'label'=>'País que visitará'))
                ->add('ciudad','text',array('required'=>false,'label'=>'Ciudad'))
                ->add('estado','text',array('required'=>false,'label'=>'Estado'))
                ->add('universidad','text',array('required'=>false,'label'=>'Universidad y departamento que visitará'))
                ->add('profesor','text',array('required'=>false,'label'=>'Profesor a quién visitará'))
                ->add('actividad','textarea',array('required'=>false,'label'=>'Actividad a desarrollar'))
                ->add('proposito','textarea',array('required'=>false,'label'=>'Propósito del viaje y/o nombre del proyecto de investigación'))
                 //->add('proyecto')
                ->add('inicio', 'date',array(
                    'widget' => 'single_text',
                    'format' => 'dd-MM-yyyy',
                    'label'=>'Fecha inicial',
                    'required'=>false))
                ->add('fin', 'date',array(
                    'widget' => 'single_text',
                    'format' => 'dd-MM-yyyy',
                    'label'=>'Fecha final',
                    'required'=>false))
                    //->add('inicio','date',array('widget' => 'single_text','format' => 'yyyy-MM-dd', 'attr' => array('class'=>'form-control', 'datepicker-popup'=> 'yyyy-MM-dd','ng-model'=>'dt',
                    //'is-open'=>'opened', 'min-date'=>'minDate', 'max-date'=>"'2014-12-31'", 'datepicker-options'=>'dateOptions', 'ng-required'=>'true', 'close-text'=>'Close' )))
                    //->add('fin','date',array('widget' => 'single_text','format' => 'yyyy-MM-dd', 'attr' => array('class'=>'form-control', 'datepicker-popup'=> 'yyyy-MM-dd','ng-model'=>'dt',
                    //'is-open'=>'opened', 'min-date'=>'minDate', 'max-date'=>"'2014-12-31'", 'datepicker-options'=>'dateOptions', 'ng-required'=>'true', 'close-text'=>'Close' )))
                ->add('trabajo','textarea',array('required'=>false,'label'=>'Título del trabajo que presentará (en su caso)'))
                ->add('financiamiento', 'collection', array(
                    'required'=>false,
                    'type' => new FinanciamientoType(),
                    'allow_add'    => true,))
                ->add('save', 'submit', array('label' => 'Guardar','validation_groups' => false,))
                ->add('saveAndAdd', 'submit', array('label' => 'Guardar y enviar'))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {

        $resolver->setDefaults(array(
            'validation_groups' => array(
                'solicitud'),




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
