<?php

namespace Ccm\SiaBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Academico Repository
 *
 * Se calculan totales basados en las solicitudes aprobadas
 * El saldo depende de la asignación anual y número de días al año disponibles.
 * Esto es independiente de lo solicitado aprobado.
 * Los parámetros de asignación anual y total de días disponibles se maneja en el controlador o vista
 *
 */
class AcademicoRepository extends EntityRepository
{
    /**
     * Erogado Licencias
     * Regresa el total de la asignación anual solicitado por licencia
     *
     */
    public function erogadoLicencias(Academico $academico)
    {
        $erogadoLic = 0;

        // Se calcula el año date("Y");
        foreach ($academico->getSolicitudes() as $solicitud) {
            if(date('Y') == $solicitud->getCreated()->format('Y') && $solicitud->getAprobada() && $solicitud->getTipo() == 'licencia')
                $erogadoLic += $solicitud->getTotalAsignación();
        }

        return $erogadoLic;
     }

    /**
     * Erogado Comisiones
     * Regresa el total de la asignación anual solicitado por comisión
     *
     */
    public function erogadoComisiones(Academico $academico)
    {
        $erogadoCom = 0;

        // Se calcula el año date("Y");
        foreach ($academico->getSolicitudes() as $solicitud) {
            if(date('Y') == $solicitud->getCreated()->format('Y') && $solicitud->getAprobada() && $solicitud->getTipo() == 'comision')
                $erogadoCom += $solicitud->getTotalAsignación();
        }

        return $erogadoCom;
    }

    /**
     * Erogado Visitantes
     * Regresa el total de la asignación anual solicitado para visitantes
     *
     */
    public function ErogadoVisitantes(Academico $academico)
    {
        $erogadoVis = 0;

        // Se calcula el año date("Y");
        foreach ($academico->getSolicitudes() as $solicitud) {
            if(date('Y') == $solicitud->getCreated()->format('Y') && $solicitud->getAprobada() && $solicitud->getTipo() == 'visitante')
                $erogadoVis += $solicitud->getTotalAsignación();
        }

        return $erogadoVis;
    }

    /**
     * Dias Solicitados de licencia
     * Regresa el total de dias solicitados por licencia
     *
     */
    public function diasSolicitadosLic()
    {
        return 0;
    }

    /**
     * Dias Solicitados de comisión
     * Regresa el total de dias solicitados por comision
     *
     */
    public function diasSolicitadosComision()
    {
        return 0;
    }
}
