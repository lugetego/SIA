<?php

namespace Ccm\SiaBundle\Entity;
use Doctrine\ORM\EntityRepository;

    class SolicitudRepository extends EntityRepository
        {
        public function findUltimasSolicitudes($limite = 10)
        {
            $em = $this->getEntityManager();
            $consulta = $em->createQuery('
                SELECT p
                FROM CcmSiaBundle:Solicitud p
                WHERE p.enviada = true
                AND p.created < :fecha
                ORDER BY p.id DESC');
            $consulta->setMaxResults($limite);
            $consulta->setParameter('fecha', new \DateTime('now'));
            return $consulta->getResult();
        }



}