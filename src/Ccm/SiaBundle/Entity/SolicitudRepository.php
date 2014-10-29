<?php

namespace Ccm\SiaBundle\Entity;
use Doctrine\ORM\EntityRepository;

class SolicitudRepository extends EntityRepository
{
    public function findUltimasSolicitudes()
    {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('
                SELECT p
                FROM CcmSiaBundle:Solicitud p
                WHERE p.enviada = true
                AND p.created < :fecha
                ORDER BY p.id DESC');
        $consulta->setMaxResults(10);
        $consulta->setParameter('fecha', new \DateTime('now'));
        return $consulta->getResult();
    }

    public function findSolicitudesByAcademico($academico)
    {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('
                SELECT p, a
                FROM CcmSiaBundle:Solicitud p
                JOIN p.academico a
                WHERE p.enviada = true
                AND p.created < :fecha
                AND a.id = :id
                ORDER BY p.id DESC');
        $consulta->setMaxResults(10);
        $consulta->setParameter('id', $academico);
        $consulta->setParameter('fecha', new \DateTime('now'));
        return $consulta->getResult();
    }



}