<?php

namespace Ccm\SiaBundle\Entity;


class Financiamiento {

    private $nombre;
    private $ccm;
    private $papiit;
    private $conacyt;
    private $otro;

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
        return;
    }

    public function getCcm()
    {
        return $this->ccm;
    }

    public function setCcm($ccm)
    {
        $this->ccm = $ccm;
        return;
    }

    public function getPapiit()
    {
        return $this->papiit;
    }

    public function setPapiit($papiit)
    {
        $this->papiit = $papiit;
        return;
    }

    public function getConacyt()
    {
        return $this->conacyt;
    }

    public function setConacyt($conacyt)
    {
        $this->conacyt = $conacyt;
        return;
    }

    public function getOtro()
    {
        return $this->otro;
    }

    public function setOtro($otro)
    {
        $this->otro = $otro;
        return;
    }

} 