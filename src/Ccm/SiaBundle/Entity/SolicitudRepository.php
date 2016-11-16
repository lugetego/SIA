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
                AND p.aprobada is null
                AND p.modified <= :fecha
                ORDER BY p.modified DESC');
        $consulta->setMaxResults(15);
        $consulta->setParameter('fecha', new \DateTime('now'));
        return $consulta->getResult();
    }

    public function findSolicitudesByAcademico($academico)
    {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('
                SELECT p
                FROM CcmSiaBundle:Solicitud p
                WHERE p.enviada = true
                AND p.created < :fecha
                AND p.academico = :id
                ORDER BY p.id DESC');
        $consulta->setMaxResults(10);
        $consulta->setParameter('id', $academico);
        $consulta->setParameter('fecha', new \DateTime('now'));
        return $consulta->getResult();
    }

}