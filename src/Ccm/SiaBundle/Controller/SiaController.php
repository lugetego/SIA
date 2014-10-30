<?php

namespace Ccm\SiaBundle\Controller;

use Ccm\SiaBundle\Entity\Financiamiento;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Ccm\SiaBundle\Entity\Solicitud;
use Ccm\SiaBundle\Entity\Academico;
use Ccm\SiaBundle\Entity\Sesiones;
use Ccm\SiaBundle\Entity\Proyecto;
use Ccm\SiaBundle\Form\SolicitudType;



/**
 * Sia controller.
 *
 * @Route("/")
 */
class SiaController extends Controller
{

    /**
     * Lists all actions on SIA .
     *
     * @Route("/", name="sia")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        if ($this->get('security.context')->isGranted('ROLE_ADMIN'))
        {
            // $entities = $em->getRepository('CcmSiaBundle:Solicitud')->findAll();
            // $entities = $em->getRepository('CcmSiaBundle:Solicitud')->findUltimasSolicitudes();
            $solicitudes = $em->getRepository('CcmSiaBundle:Solicitud')->findUltimasSolicitudes();
            $academicos = $em->getRepository('CcmSiaBundle:Academico')->findAll();
            $proyectos = $em->getRepository('CcmSiaBundle:Proyecto')->findAll();



        }
        else{
            $user = $this->get('security.context')->getToken()->getUser();
            //$solicitudes = $user->getAcademico()->getSolicitudes();
            $academico = $user->getAcademico();
            $proyectos = $academico->getProyectos();

            $solicitudes = $em->getRepository('CcmSiaBundle:Solicitud')->findSolicitudesByAcademico($academico->getId());
            $academico = $user->getId();
            $academicos = $em->getRepository('CcmSiaBundle:Academico')->findByUser($academico);
           // $proyectos = $em->getRepository('CcmSiaBundle:Proyecto')->findByAcademico($academico);


        }

        $sesiones =  $em->getRepository('CcmSiaBundle:Sesiones')->findAll();

        return array(
            'solicitudes' => $solicitudes, 'sesiones' => $sesiones, 'academicos' => $academicos, 'proyectos' => $proyectos
        );


    }

}
