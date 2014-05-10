<?php

namespace Ccm\SiaBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="Ccm\SiaBundle\Entity\Academico", mappedBy="user")
     */
    private $academico;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }



    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set academico
     *
     * @param \Ccm\SiaBundle\Entity\Academico $academico
     * @return User
     */
    public function setAcademico(\Ccm\SiaBundle\Entity\Academico $academico = null)
    {
        $this->academico = $academico;

        return $this;
    }

    /**
     * Get academico
     *
     * @return \Ccm\SiaBundle\Entity\Academico 
     */
    public function getAcademico()
    {
        return $this->academico;
    }
}
