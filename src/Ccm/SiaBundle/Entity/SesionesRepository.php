<?php

namespace Ccm\SiaBundle\Entity;
use Doctrine\ORM\EntityRepository;

class SesionesRepository extends EntityRepository
{

    public function countSolicitudesTipo()
    {
        $em = $this->getEntityManager();

        $consulta = $em->createQuery('
                SELECT s
                FROM CcmSiaBundle:Solicitud s
                WHERE s.sesion = true
                AND p.aprobada is null
                AND p.modified <= :fecha
                ORDER BY p.modified DESC');
        $consulta->setMaxResults(15);
        $consulta->setParameter('fecha', new \DateTime('now'));
        return $consulta->getResult();
    }

}