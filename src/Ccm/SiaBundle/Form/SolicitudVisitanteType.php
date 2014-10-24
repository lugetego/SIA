<?php

namespace Ccm\SiaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Ccm\SiaBundle\Form\FinanciamientoType;
use Ccm\SiaBundle\Entity\Academico;


class SolicitudVisitanteType extends AbstractType
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
            ->add('tipo', 'choice', array('required'=>true,
                'choices'=>array(
                    'visitante'=>'Visitante',

                ),'data' => 'visitante'));

        if ( false === $this->securityContext->isGranted('ROLE_ADMIN') ) {

            $builder
                ->add('academico', 'entity', array(
                    'class' => 'Ccm\SiaBundle\Entity\Academico',
                    'required'=>false,
                    'query_builder'=> function(\Doctrine\ORM\EntityRepository  $er) use ($user) {
                        return $er->createQueryBuilder('q')
                                ->select('r')
                                ->from('Ccm\SiaBundle\Entity\Academico', 'r')
                                ->leftjoin('r.user','a')
                                ->where('a.id = :id')
                                ->setParameter('id', $user->getId())
                                ;}, 'multiple' => true, 'expanded'=>false))

                ->add('proyecto', 'entity', array(
                    'class' => 'Ccm\SiaBundle\Entity\Proyecto',
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
                ->add('academico',null,array('required'=>false))
                ->add('proyecto', 'entity', array(
                    'required'=>false,
                    'empty_value' => 'Choose an option',
                    'class' => 'Ccm\SiaBundle\Entity\Proyecto',
                    'query_builder'=> function(\Doctrine\ORM\EntityRepository  $er) use ($user) {
                         return $er->createQueryBuilder('q')
                                 ->select('r')
                                 ->from('Ccm\SiaBundle\Entity\Proyecto', 'r')
                                 ;}, ));
        }

            $builder->add('sesion',null,array('required'=>false))
                    ->add('pais','text',array('required'=>false,'label'=>'País de procedencia'))
                    ->add('ciudad','text',array('required'=>false,'label'=>'Ciudad de procedencia'))
                    ->add('estado','text',array('required'=>false,'label'=>'Estado'))
                    ->add('universidad','text',array('required'=>false,'label'=>'Institución'))
                    ->add('profesor','text',array('required'=>false,'label'=>'Nombre del invitado'))

                    ->add('proposito','textarea',array('required'=>false,'label'=>'Objeto de la visita'))
                    //->add('proyecto')
                    ->add('inicio', 'date',array('widget' => 'single_text', 'format' => 'yyyy-MM-dd','label'=>'Fecha inicial','required'=>false))
                    ->add('fin', 'date',array('widget' => 'single_text', 'format' => 'yyyy-MM-dd','label'=>'Fecha final','required'=>false))
                    //->add('inicio','date',array('widget' => 'single_text','format' => 'yyyy-MM-dd', 'attr' => array('class'=>'form-control', 'datepicker-popup'=> 'yyyy-MM-dd','ng-model'=>'dt',
                    //'is-open'=>'opened', 'min-date'=>'minDate', 'max-date'=>"'2014-12-31'", 'datepicker-options'=>'dateOptions', 'ng-required'=>'true', 'close-text'=>'Close' )))
                    //->add('fin','date',array('widget' => 'single_text','format' => 'yyyy-MM-dd', 'attr' => array('class'=>'form-control', 'datepicker-popup'=> 'yyyy-MM-dd','ng-model'=>'dt',
                    //'is-open'=>'opened', 'min-date'=>'minDate', 'max-date'=>"'2014-12-31'", 'datepicker-options'=>'dateOptions', 'ng-required'=>'true', 'close-text'=>'Close' )))

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
