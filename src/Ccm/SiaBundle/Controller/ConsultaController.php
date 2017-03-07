<?php

namespace Ccm\SiaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ConsultaController extends Controller
{
    /**
     * @Route("/consulta")
     */
    public function consultaAction()
    {
        return $this->render('CcmSiaBundle:Consulta:consulta.html.twig', array(
            // ...
        ));
    }

}
