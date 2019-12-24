<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Reservation
 * @package App\Entity
 *
 * @ApiResource()
 * @ORM\Entity
 */
class Reservation
{
    /**
     * @var int Id de la ville
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string Nom de la ville
     *
     * @ORM\Column
     * @Assert\NotBlank
     */
    public $nom = '';

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Hotel", inversedBy="reservations", cascade={"persist"})
     * @ORM\JoinColumn(name="hotel", referencedColumnName="id")
     * @Assert\NotBlank
     */
    public $hotel;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param $nom
     * @return $this
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getHotel()
    {
        return $this->hotel;
    }

    /**
     * @param $hotel
     * @return $this
     */
    public function setHotel($hotel)
    {
        $this->hotel = $hotel;
        return $this;
    }
}
