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


}
