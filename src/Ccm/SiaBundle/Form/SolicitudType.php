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
                ->add('academico',null, array(
                    'class' => 'Ccm\SiaBundle\Entity\Academico',
                    'label' => 'Académico',
                    'read_only'=>'true',
                    'required'=>true,
                    'disabled'  => false,
                    'query_builder'=> function(\Doctrine\ORM\EntityRepository  $er) use ($user) {
                        return $er->createQueryBuilder('q')
                            ->select('r')
                            ->from('Ccm\SiaBundle\Entity\Academico', 'r')
                            ->leftjoin('r.user','a')
                            ->where('a.id = :id')
                            ->setParameter('id', $user->getId())
                            ;}, 'data' => ($user->getAcademico())));

            /*                ->add('proyecto', null, array(
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
                                            ;}, ));*/
        }

        else {

            $builder
                ->add('academico',null,array(
                    'required'=>true,
                    'label'=>'Académico',
                    'empty_value' => 'Seleccionar'));
            /*                ->add('proyecto',null, array(
                                'required'=>false,
                                'empty_value' => 'Seleccionar',
                                'class' => 'Ccm\SiaBundle\Entity\Proyecto',
                                'query_builder'=> function(\Doctrine\ORM\EntityRepository  $er) use ($user) {
                                     return $er->createQueryBuilder('q')
                                             ->select('r')
                                             ->from('Ccm\SiaBundle\Entity\Proyecto', 'r')
                                             ;}, ));*/
        }

        $builder
            /*    ->add('sesion',null,array(
                    'required'=>false,
                    'empty_value' => 'Seleccionar',
                    'label'=> 'Sesión de consejo'))*/
            ->add('sesion',null,array(
                'required'=>false,
                'label'=>'Sesión de Consejo Interno',
                'class'=> 'Ccm\SiaBundle\Entity\Sesiones',
                'query_builder' => function(\Doctrine\ORM\EntityRepository $er) {
                    return $er->createQueryBuilder('q')
                        ->select('r')
                        ->from('Ccm\SiaBundle\Entity\Sesiones', 'r')
                        ->where('r.fecha >= :now')
                        ->setParameter('now', new \DateTime("01-01-2016"));
                }
            ))
            ->add('pais','text',array(
                'required'=>false,
                'label'=>'País que visitará'
            ))
            ->add('ciudad','text',array(
                'required'=>false,
                'label'=>'Ciudad'
            ))
            ->add('estado','text',array(
                'required'=>false,
                'label'=>'Estado'
            ))
            ->add('universidad','text',array(
                'required'=>false,
                'label'=>'Universidad y departamento que visitará'
            ))
            ->add('actividad','textarea',array(
                'required'=>false,
                'label'=>'Actividad a desarrollar'
            ))
            ->add('proposito','choice',array(
                'choices'   =>  $this->getPropositoChoice(),
                'required'=>false,
                'label'=>'Propósito del viaje'
            ))
            ->add('profesor','text',array(
                'required'=>false,
                'label'=>'Profesor a quién visitará'
            ))
            ->add('inicio', 'date',array(
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'label'=>'Fecha inicial',
                'required'=>false
            ))
            ->add('fin', 'date',array(
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'label'=>'Fecha final',
                'required'=>false
            ))
            //->add('inicio','date',array('widget' => 'single_text','format' => 'yyyy-MM-dd', 'attr' => array('class'=>'form-control', 'datepicker-popup'=> 'yyyy-MM-dd','ng-model'=>'dt',
            //'is-open'=>'opened', 'min-date'=>'minDate', 'max-date'=>"'2014-12-31'", 'datepicker-options'=>'dateOptions', 'ng-required'=>'true', 'close-text'=>'Close' )))
            //->add('fin','date',array('widget' => 'single_text','format' => 'yyyy-MM-dd', 'attr' => array('class'=>'form-control', 'datepicker-popup'=> 'yyyy-MM-dd','ng-model'=>'dt',
            //'is-open'=>'opened', 'min-date'=>'minDate', 'max-date'=>"'2014-12-31'", 'datepicker-options'=>'dateOptions', 'ng-required'=>'true', 'close-text'=>'Close' )))
            ->add('trabajo','textarea',array(
                'required'=>false,
                'label'=>'Título del trabajo que presentará (en su caso)'
            ));

        if ( true === $this->securityContext->isGranted('ROLE_ADMIN') ) {
            $builder
                ->add('aprobada', 'choice', array(
                    'choices' => array(
                        false => 'No',
                        true => 'Si'
                    ),
                    'required'    => false,
                    'empty_value' => 'Seleccionar',
                    'empty_data'  => null
                ));
        }
        $builder
            ->add('cartaInvitacionFile', 'vich_file', array(
                'required'      => false, 'label' => 'PDF Carta de Invitación'
            ))
            ->add('planTrabajoFile', 'vich_file', array(
                'required'      => false, 'label' => 'PDF Plan de Trabajo'
            ))
            ->add('observaciones','textarea',array(
                'required'=>false,
                'label'=>'Observaciones'
            ))
            ->add('financiamiento', 'collection', array(
                'required'=>false,
                'type' => new FinanciamientoType(),
                'allow_add' => true
            ))
            ->add('save', 'submit', array(
                'label' => 'Guardar',
                'validation_groups' => false
            ))
            ->add('saveAndAdd', 'submit', array(
                'label' => 'Guardar y enviar'
            ));
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

    /**
     * @return array
     */
    private function getPropositoChoice()
    {
        return array(
            'Asamblea' => 'Asamblea',
            'Asesoría' => 'Asesoría',
            'Capacitación' => 'Capacitación',
            'Cátedra' => 'Cátedra',
            'Ceremonia' => 'Ceremonia',
            'Colaboración' => 'Colaboración',
            'Coloquio' => 'Coloquio',
            'Comité' => 'Comité',
            'Concurso' => 'Concurso',
            'Conferencia' => 'Conferencia',
            'Congreso' => 'Congreso',
            'Conmemoración' => 'Conmemoración',
            'Consultoría' => 'Consultoría',
            'Convención' => 'Convención',
            'Convenio' => 'Convenio',
            'Coordinación' => 'Coordinación',
            'Curso' => 'Curso',
            'Curso-Taller' => 'Curso-Taller',
            'Demostración' => 'Demostración',
            'Dictamen' => 'Dictamen',
            'Diplomado' => 'Diplomado',
            'Encuentro' => 'Encuentro',
            'Entrevista' => 'Entrevista',
            'Estancia' => 'Estancia',
            'Estudio' => 'Estudio',
            'Evaluación' => 'Evaluación',
            'Examen' => 'Examen',
            'Exposición' => 'Exposición',
            'Feria' => 'Feria',
            'Feria-Posgrado' => 'Feria-Posgrado',
            'Foro' => 'Foro',
            'Homenaje' => 'Homenaje',
            'Inauguración' => 'Inauguración',
            'Instalación' => 'Instalación',
            'Intercambio' => 'Intercambio',
            'Investigación' => 'Investigación',
            'Jornadas' => 'Jornadas',
            'Jurado' => 'Jurado',
            'Mesa redonda' => 'Mesa redonda',
            'Minicongreso' => 'Minicongreso',
            'Minicurso' => 'Minicurso',
            'Minisimposio' => 'Minisimposio',
            'Olimpiada' => 'Olimpiada',
            'Organización' => 'Organización',
            'Panel' => 'Panel',
            'Plática' => 'Plática',
            'Ponencia' => 'Ponencia',
            'Premiación' => 'Premiación',
            'Presentación' => 'Presentación',
            'Proyecto' => 'Proyecto',
            'Reconocimiento' => 'Reconocimiento',
            'Reunión' => 'Reunión',
            'Revisión' => 'Revisión',
            'Seminario' => 'Seminario',
            'Simposio' => 'Simposio',
            'Sinodal' => 'Sinodal',
            'Supervisión' => 'Supervisión',
            'Taller' => 'Taller',
            'Trabajo' => 'Trabajo',
            'Trabajo de campo' => 'Trabajo de campo',
            'Vinculación' => 'Vinculación',
            'Visita' => 'Visita',
        );
    }
}
