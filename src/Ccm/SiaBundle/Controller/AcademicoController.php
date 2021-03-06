<?php

namespace Ccm\SiaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Ccm\SiaBundle\Entity\Academico;
use Ccm\SiaBundle\Form\AcademicoType;

/**
 * Academico controller.
 *
 * @Route("/academico")
 */
class AcademicoController extends Controller
{

    /**
     * Lists all Academico entities.
     *
     * @Route("/", name="academico")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CcmSiaBundle:Academico')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Academico entity.
     *
     * @Route("/", name="academico_create")
     * @Method("POST")
     * @Template("CcmSiaBundle:Academico:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Academico();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('info', 'El registro se ha guardado exitosamente');

            return $this->redirect($this->generateUrl('academico_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Academico entity.
    *
    * @param Academico $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Academico $entity)
    {
        $securityContext = $this->container->get('security.context');

        $form = $this->createForm(new AcademicoType($securityContext), $entity, array(
            'action' => $this->generateUrl('academico_create'),
            'method' => 'POST',
        ));

        //$form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Academico entity.
     *
     * @Route("/new", name="academico_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $securityContext = $this->container->get('security.context');

        $entity = new Academico($securityContext);
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Academico entity.
     *
     * @Route("/{id}", name="academico_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CcmSiaBundle:Academico')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Academico entity.');
        }

        $asignacionAnual = $this->container->getParameter('sia.asignacion_anual');
        $dLic = $this->container->getParameter('sia.dias_licencia');
        $dCom = $this->container->getParameter('sia.dias_comision');
        $year = $this->container->getParameter('sia.year');

        $totalDias = $dLic + $dCom;

        // Calcula Totales
        $totalAsignacionLicencia = $em->getRepository('CcmSiaBundle:Academico')->erogadoLicencias($entity);
        $totalAsignacionComision = $em->getRepository('CcmSiaBundle:Academico')->erogadoComisiones($entity);
        $totalAsignacionVisitante = $em->getRepository('CcmSiaBundle:Academico')->erogadoVisitantes($entity);
        $totalDiasLicencia = $em->getRepository('CcmSiaBundle:Academico')->diasSolicitadosLicencia($entity);
        $totalDiasComision = $em->getRepository('CcmSiaBundle:Academico')->diasSolicitadosComision($entity);

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'asignacionLicencia' => $totalAsignacionLicencia,
            'asignacionComision' => $totalAsignacionComision,
            'asignacionVisitante' => $totalAsignacionVisitante,
            'diasLicencia' => $totalDiasLicencia,
            'diasComision' => $totalDiasComision,
            'totalDias' => $totalDias,
            'asignacionAnual' => $asignacionAnual,
        );
    }

    /**
     * Displays a form to edit an existing Academico entity.
     *
     * @Route("/{id}/edit", name="academico_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CcmSiaBundle:Academico')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Academico entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Academico entity.
    *
    * @param Academico $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Academico $entity)
    {
        $securityContext = $this->container->get('security.context');

        $form = $this->createForm(new AcademicoType($securityContext), $entity, array(
            'action' => $this->generateUrl('academico_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        //$form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Academico entity.
     *
     * @Route("/{id}", name="academico_update")
     * @Method("PUT")
     * @Template("CcmSiaBundle:Academico:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CcmSiaBundle:Academico')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Academico entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
            $this->get('session')->getFlashBag()->add('info', 'El registro se ha modificado exitosamente');

            return $this->redirect($this->generateUrl('academico_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Academico entity.
     *
     * @Route("/{id}", name="academico_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CcmSiaBundle:Academico')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Academico entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('academico'));
    }

    /**
     * Creates a form to delete a Academico entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('academico_delete', array('id' => $id)))
            ->setMethod('DELETE')
            //->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
