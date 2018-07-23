<?php

namespace AppBundle\Entity;

use JMS\Serializer\Annotation\Type;

use Doctrine\ORM\Mapping as ORM;

/**
 * ticket
 *
 * @ORM\Table(name="ticket")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ticketRepository")
 */
class ticket
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_Completado", type="datetime")
     */
    private $fecha_Completada;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255, nullable=true)
     */
    private $descripcion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_Creada", type="datetime")
     */
    private $fecha_Creada;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Usuario", inversedBy="tickets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $usuario;

    /**
     * $notas
     * @ORM\OneToMany(targetEntity="Nota", mappedBy="ticketId")
     */
    private $notas;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Usuario", inversedBy="ticketsAsignados")
     * @ORM\JoinColumn(nullable=false)
     */
    private $usuarioAsignado;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=255)
     */
    private $estado;

    public function __construct()
    {
        $this->notas = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getNotas()
    {
        return $this->notas;
    }

    /**
     * @param int $notas
     */
    public function setNotas($notas)
    {
        $this->notas = $notas;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return \DateTime
     */
    public function getFechaCompletada()
    {
        return $this->fecha_Completada;
    }

    /**
     * @param \DateTime $fecha_Completada
     */
    public function setFechaCompletada($fecha_Completada)
    {
        $this->fecha_Completada = $fecha_Completada;
    }

    /**
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * @param string $descripcion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    /**
     * @return \DateTime
     */
    public function getFechaCreada()
    {
        return $this->fecha_Creada;
    }

    /**
     * @param \DateTime $fecha_Creada
     */
    public function setFechaCreada($fecha_Creada)
    {
        $this->fecha_Creada = $fecha_Creada;
    }

    /**
     * @return int
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param int $usuario
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    /**
     * @return int
     */
    public function getUsuarioAsignado()
    {
        return $this->usuarioAsignado;
    }

    /**
     * @param int $usuarioAsignado
     */
    public function setUsuarioAsignado($usuarioAsignado)
    {
        $this->usuarioAsignado = $usuarioAsignado;
    }

    /**
     * @return string
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * @param string $estado
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }




}

