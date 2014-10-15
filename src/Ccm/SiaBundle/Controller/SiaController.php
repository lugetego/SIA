<?php

namespace Ccm\SiaBundle\Controller;

use Ccm\SiaBundle\Entity\Financiamiento;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Ccm\SiaBundle\Entity\Solicitud;
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
        if ($this->get('security.context')->isGranted('ROLE_ADMIN'))
        {
            $em = $this->getDoctrine()->getManager();
            $solicitudes = $em->getRepository('CcmSiaBundle:Solicitud')->findAll();
            $sesiones =  $em->getRepository('CcmSiaBundle:Sesiones')->findAll();
        }
        else{
            $user = $this->get('security.context')->getToken()->getUser();
            $solicitudes = $user->getAcademico()->getSolicitudes();
        }


        return array(
            'solicitudes' => $solicitudes, 'sesiones' => $sesiones
        );


    }

}
