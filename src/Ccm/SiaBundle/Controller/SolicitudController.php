<?php

namespace Ccm\SiaBundle\Controller;

use Ccm\SiaBundle\Entity\Financiamiento;
use Ccm\SiaBundle\Security\SolicitudVoter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Ccm\SiaBundle\Entity\Solicitud;
use Ccm\SiaBundle\Entity\Proyecto;
use Ccm\SiaBundle\Form\SolicitudType;
use Ccm\SiaBundle\Form\SolicitudVisitanteType;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;



/**
 * Solicitud controller.
 *
 * @Route("/solicitud")
 */
class SolicitudController extends Controller
{

    /**
     * Lists all Solicitud entities.
     *
     * @Route("/", name="solicitud")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {

        return $this->render('CcmSiaBundle:Solicitud:index.html.twig');
    }
    /**
     * Creates a new Solicitud entity.
     *
     * @Route("/", name="solicitud_create")
     * @Method("POST")
     * @Template("CcmSiaBundle:Solicitud:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $securityContext = $this->container->get('security.context');

        //// Donde se utiliza user?
        $user = $securityContext->getToken()->getUser();

        $entity = new Solicitud($securityContext);

        $tipo = $request->request->all();
        $tipo = $tipo['ccm_siabundle_solicitud']['tipo-form'];

        $form = $this->createCreateForm($entity, $tipo);
        //$form = $this->createForm(new SolicitudType(), $entity);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

/*            $proyecto = $form->get('proyecto')->getData();
            $entity->getProyecto($proyecto);*/

            $em->persist($entity);
            $em->flush();

            //return $this->redirect($this->generateUrl('solicitud_show', array('id' => $entity->getId())));

            $nextAction = $form->get('saveAndAdd')->isClicked()
                ? 'solicitud_send'
                : 'solicitud_show';


            $this->get('session')->getFlashBag()->add('info', 'El registro se ha guardado exitosamente');

            return $this->redirect($this->generateUrl($nextAction, array('id' => $entity->getId())));

            //    return $content = $this->render('CcmSiaBundle:Solicitud:confirm.html.twig', array('id' => $entity->getId(),'entity'=>$entity));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Solicitud entity.
    *
    * @param Solicitud $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Solicitud $entity, $tipo)
    {
        $securityContext = $this->container->get('security.context');

        if( $tipo == 'licencia-comision'){
        $form = $this->createForm(new SolicitudType($securityContext),$entity, array(
            'action' => $this->generateUrl('solicitud_create'),
            'method' => 'POST',

        ));
            $form->add('tipo-form','hidden', array('data' => 'licencia-comision', 'mapped'=>false));
        }
        elseif( $tipo == 'visitante'){
            $form = $this->createForm(new SolicitudVisitanteType($securityContext),$entity, array(
                'action' => $this->generateUrl('solicitud_create'),
                'method' => 'POST',

            ));
            $form->add('tipo-form', 'hidden', array('data' => 'visitante', 'mapped'=>false));
        }

        //$form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Solicitud entity.
     *
     * @Route("/new/{tipo}", name="solicitud_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction($tipo)
    {
        $entity = new Solicitud();

        $viaticos = new Financiamiento();
        $viaticos->setNombre("Viáticos");
        $viaticos->setCcm(0);
        $viaticos->setPapiit(0);
        $viaticos->setConacyt(0);
        $viaticos->setOtro(0);
        $entity->getFinanciamiento()->add($viaticos);

        $aereo = new Financiamiento();
        $aereo->setNombre("Pasaje aéreo");
        $aereo->setCcm(0);
        $aereo->setPapiit(0);
        $aereo->setConacyt(0);
        $aereo->setOtro(0);
        $entity->getFinanciamiento()->add($aereo);

        $terrestre = new Financiamiento();
        $terrestre->setNombre("Pasaje terrestre");
        $terrestre->setCcm(0);
        $terrestre->setPapiit(0);
        $terrestre->setConacyt(0);
        $terrestre->setOtro(0);
        $entity->getFinanciamiento()->add($terrestre);

        $inscripciones = new Financiamiento();
        $inscripciones->setNombre("Inscripciones");
        $inscripciones->setCcm(0);
        $inscripciones->setPapiit(0);
        $inscripciones->setConacyt(0);
        $inscripciones->setOtro(0);
        $entity->getFinanciamiento()->add($inscripciones);

        $form   = $this->createCreateForm($entity,$tipo);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Solicitud entity.
     *
     * @Route("/{id}", name="solicitud_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CcmSiaBundle:Solicitud')->find($id);

        $context = $this->get('security.context');

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Solicitud entity.');
        }

        if (false === $context->isGranted(SolicitudVoter::VIEW, $entity)) {

            throw new AccessDeniedException('Access denied!');
        }

        elseif ( false === $context->isGranted('ROLE_ACADEMICO')) {

            throw new AccessDeniedException('Access denied!');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Solicitud entity.
     *
     * @Route("/{id}/edit", name="solicitud_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CcmSiaBundle:Solicitud')->find($id);
        $tipo = $entity->getTipo();

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Solicitud entity.');
        }

        if (false === $this->get('security.context')->isGranted(SolicitudVoter::EDIT, $entity)) {

            throw new AccessDeniedException('Access denied!');

        }

        $editForm = $this->createEditForm($entity,$tipo);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Solicitud entity.
    *
    * @param Solicitud $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Solicitud $entity,$tipo)
    {
        $securityContext = $this->container->get('security.context');

        if( $tipo == 'licencia' || $tipo == 'comision'){
            $form = $this->createForm(new SolicitudType($securityContext),$entity, array(
                'action' => $this->generateUrl('solicitud_update', array('id' => $entity->getId())),
                'method' => 'PUT',

            ));
        }
        elseif( $tipo == 'visitante'){
            $form = $this->createForm(new SolicitudVisitanteType($securityContext),$entity, array(
                'action' => $this->generateUrl('solicitud_update', array('id' => $entity->getId())),
                'method' => 'PUT',

            ));

        }

        return $form;
    }
    /**
     * Edits an existing Solicitud entity.
     *
     * @Route("/{id}", name="solicitud_update")
     * @Method("PUT")
     * @Template("CcmSiaBundle:Solicitud:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $logger = $this->get('logger');

        $entity = $em->getRepository('CcmSiaBundle:Solicitud')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Solicitud entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity,$entity->getTipo());
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            //http://stackoverflow.com/questions/11084209/how-to-force-doctrine-to-update-array-type-fields

            $financiamientos = $entity->getFinanciamiento();
            $financiamiento[0] = clone $financiamientos[0];
            $financiamiento[1] = clone $financiamientos[1];
            $financiamiento[2] = clone $financiamientos[2];
            $financiamiento[3] = clone $financiamientos[3];

            $entity->setFinanciamiento($financiamiento);

            $em->flush();
            $this->get('session')->getFlashBag()->add('info', 'El registro se ha modificado exitosamente');

            $nextAction = $editForm->get('saveAndAdd')->isClicked()
                ? 'solicitud_send'
                : 'solicitud_show';

            return $this->redirect($this->generateUrl($nextAction, array('id' => $entity->getId())));

            $logger->notice('Solicitud Edit persist', array('id' => $id));

            //return $this->redirect($this->generateUrl('solicitud_edit', array('id' => $id)));
            return $content = $this->render('CcmSiaBundle:Solicitud:confirm.html.twig', array('id' => $entity->getId(),'entity'=>$entity));

        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Solicitud entity.
     *
     * @Route("/{id}", name="solicitud_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CcmSiaBundle:Solicitud')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Solicitud entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('sia'));
    }

    /**
     * Creates a form to delete a Solicitud entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('solicitud_delete', array('id' => $id)))
            ->setMethod('DELETE')
            //->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }


    /**
     * Envía la solicitud a la Secretaría Académica
     *
     * @Route("/{id}/send", name="solicitud_send")
     * @Method("GET")
     * @Template()
     */
    public function sendAction(Request $request, $id)
    {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CcmSiaBundle:Solicitud')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Solicitud entity.');
        }

        if ( $entity->getEnviada()== null ) {

            $entity->setEnviada(true);

            $em->persist($entity);
            $em->flush();

            $user = $this->get('security.context')->getToken()->getUser();
            $mail = $user->getEmail();

            // Obtiene correo y msg de la forma de contacto
            $mailer = $this->get('mailer');


//            $message = \Swift_Message::newInstance()
//                ->setSubject('Registro de solicitud')
//                ->setFrom('info@matmor.unam.mx')
//                //->setTo(array($entity->getCorreo()))
//                ->setTo($mail)
//                //->setBcc(array('webmaster@matmor.unam.mx','escuela@matmor.unam.mx'))
//                ->setBody($this->renderView('CcmSiaBundle:Solicitud:email.txt.twig', array('entity' => $entity)));

            // $mailer->send($message);

            $this->get('session')->getFlashBag()->add(
                'info',
                'Se ha enviado un correo de notificación a tu cuenta y a la Secretaría Académica para la revisión de tu solicitud'
            );

            $this->get('session')->getFlashBag()->add(
                'info',
                'Tu solicitud se ha enviado correctamente');


            return $content = $this->render('CcmSiaBundle:Solicitud:show.html.twig', array('id' => $entity->getId(), 'entity' => $entity));
        }

        else {

            $this->get('session')->getFlashBag()->add(
                'info',
                'Esta solicitud ya fue enviada.');


            return $content = $this->render('CcmSiaBundle:Solicitud:show.html.twig', array('id' => $entity->getId(), 'entity' => $entity));
        }
    }

    /**
     * Envía la solicitud a la Secretaría Académica
     *
     * @Route("/{id}/notify", name="solicitud_notify")
     * @Method("GET")
     * @Template()
     */
    public function notifyAction(Request $request, $id)
    {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CcmSiaBundle:Solicitud')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Solicitud entity.');
        }

        $entity->setNotificada(true);

        $em->persist($entity);
        $em->flush();

        $user = $this->get('security.context')->getToken()->getUser();
        $mail = $user->getEmail();

        // Obtiene correo y msg de la forma de contacto
        $mailer = $this->get('mailer');


        $message = \Swift_Message::newInstance()
            ->setSubject('Notificación de solicitud')
            ->setFrom('info@matmor.unam.mx')
            //->setTo(array($entity->getCorreo()))
            ->setTo($mail)
            //->setBcc(array('webmaster@matmor.unam.mx','escuela@matmor.unam.mx'))
            ->setBody($this->renderView('CcmSiaBundle:Solicitud:notificacion.txt.twig', array('entity' => $entity)));

        $mailer->send($message);

        $this->get('session')->getFlashBag()->add(
            'info',
            'Se ha enviado un correo de notificación.'
        );


        return $content = $this->render('CcmSiaBundle:Solicitud:show.html.twig', array('id' => $entity->getId(),'entity'=>$entity));

    }

    /**
     * Seguimiento de solicitudes
     * @Route("/seguimiento/", name="solicitud_seguimiento")
     */
    public function seguimientoAction()
    {
       // $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if ($this->get('security.context')->isGranted('ROLE_ADMIN'))
        {
            $em = $this->getDoctrine()->getManager();
            $entities = $em->getRepository('CcmSiaBundle:Solicitud')->findAll();
        }
        else{
            $user = $this->get('security.context')->getToken()->getUser();
            $entities = $user->getAcademico()->getSolicitudes();
        }

        //TODO: Caso no es ADMIN y no es Académico

        return $content = $this->render('CcmSiaBundle:Solicitud:seguimiento.html.twig', array('entities' => $entities));


    }
}
