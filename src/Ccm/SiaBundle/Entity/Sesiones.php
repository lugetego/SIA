<?php

namespace Ccm\SiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity
 * @ORM\Table(name="sesiones")
 * @ORM\HasLifecycleCallbacks
 * @Vich\Uploadable
 */
class Sesiones
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank()
     */
    protected $fecha;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=120)
     */
    protected $name;

    /**
     * @var array $solicitudes
     *
     * @ORM\OneToMany(targetEntity="Ccm\SiaBundle\Entity\Solicitud", mappedBy="sesion")
     *
     * The mappedBy attribute designates the field in the entity that is the owner of the relationship.
     */
    private $solicitudes;

    /**
     * @Vich\UploadableField(mapping="acta_sesion_consejo", fileNameProperty="actaConsejoName")
     *
     * @var File
     * @Assert\File(
     *     maxSize = "6M",
     *     mimeTypes = {"application/pdf", "application/x-pdf"},
     *     mimeTypesMessage = "Please upload a valid PDF"
     * )
     * @Assert\NotBlank(message = "Acta de Consejo", groups={"comision"})
     */
    private $actaConsejoFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     *
     */
    private $actaConsejoName;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->setUpdatedAt(new \DateTime());
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
        $this->setUpdatedAt(new \DateTime());
    }

    /**
     * Set updatedAt
     *
     * @param datetime $updated
     */
    public function setUpdatedAt($updated)
    {
        $this->updatedAt = $updated;
    }

    /**
     * Get updated
     *
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->solicitudes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Sesiones
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime 
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Sesiones
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add solicitudes
     *
     * @param \Ccm\SiaBundle\Entity\Solicitud $solicitudes
     * @return Sesiones
     */
    public function addSolicitude(\Ccm\SiaBundle\Entity\Solicitud $solicitudes)
    {
        $this->solicitudes[] = $solicitudes;

        return $this;
    }

    /**
     * Remove solicitudes
     *
     * @param \Ccm\SiaBundle\Entity\Solicitud $solicitudes
     */
    public function removeSolicitude(\Ccm\SiaBundle\Entity\Solicitud $solicitudes)
    {
        $this->solicitudes->removeElement($solicitudes);
    }

    /**
     * Get solicitudes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSolicitudes()
    {
        return $this->solicitudes;
    }

    // -----------------------------------------------------------------------------------------------------------------
    // File upload Carta Invitacion
    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $actaConsejo
     */
    public function setActaConsejoFile(File $actaConsejo = null)
    {
        $this->cartaActaConsejoFile = $actaConsejo;

        if ($actaConsejo) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->modified = new \DateTime('now');
        }
    }

    /**
     * @return File
     */
    public function getActaConsejoFile()
    {
        return $this->actaConsejoFile;
    }

    /**
     * @param string $actaConsejoName
     */
    public function setActaConsejoName($actaConsejoName)
    {
        $this->actaConsejoName = $actaConsejoName;
    }

    /**
     * @return string
     */
    public function getActaConsejoName()
    {
        return $this->actaConsejoName;
    }

    public function __toString()
    {
        return $this->name . ' | ' . $this->fecha->format('d-m-Y');
    }
}
