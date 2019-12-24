<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Reservation
 *
 * @ApiResource(
 *     normalizationContext={"groups"={"ville.hotel"}},
 *     denormalizationContext={"groups"={"ville.hotel"}}
 * )
 * @ORM\Entity
 */
class Ville
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
     * @Groups({"ville.hotel"})
     */
    public $nom = '';

    /**
     * @ORM\OneToMany(
     *     targetEntity="App\Entity\Hotel",
     *     mappedBy="ville",
     *     cascade={"persist", "remove"}
     *     )
     */
    public $hotels;

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
     * @param string $nom
     * @return Ville
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getHotels()
    {
        return $this->hotels;
    }

    /**
     * @param mixed $hotels
     * @return Ville
     */
    public function setHotels($hotels)
    {
        $this->hotels = $hotels;
        return $this;
    }
}
