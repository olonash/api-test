<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Entity hotel
 *
 * @ApiResource(
 *     collectionOperations={
 *          "get",
 *          "liste_hotel_ville"={
 *              "method"="GET",
 *              "path"="/hotels-par-ville/{id}",
 *              "controller"=HotelController::class,
 *              "normalization_context"={"groups"={"ville.hotel"}}
 *          }
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\HotelRepository")
 */
class Hotel
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
     * @var string Nom de l'hotel
     *
     * @ORM\Column
     * @Assert\NotBlank
     * @Groups({"ville.hotel"})
     */
    public $nom = '';

    /**
     * @var int Prix hotel adulte
     *
     * @ORM\Column(name="prix_adulte", type="integer")
     * @Assert\NotBlank
     */
    public $prixAdulte = 0;

    /**
     * @var int Prix enfant
     *
     * @ORM\Column(name="prix_enfant", type="integer")
     * @Assert\NotBlank
     */
    public $prixEnfant= 0;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ville", inversedBy="hotels", cascade={"persist"}, fetch="EAGER")
     * @ORM\JoinColumn(name="ville", referencedColumnName="id")
     * @Assert\NotBlank
     */
    public $ville;


    /**
     * @ORM\OneToMany(
     *     targetEntity="App\Entity\Reservation",
     *     mappedBy="hotel",
     *     cascade={"persist", "remove"}
     *     )
     */
    public $reservations;

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
     * @param string $nom
     * @return Hotel
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
        return $this;
    }

    /**
     * @return int
     */
    public function getPrixAdulte()
    {
        return $this->prixAdulte;
    }

    /**
     * @param int $prix_adulte
     * @return Hotel
     */
    public function setPrixAdulte($prix_adulte)
    {
        $this->prixAdulte = $prix_adulte;
        return $this;
    }

    /**
     * @return int
     */
    public function getPrixEnfant()
    {
        return $this->prixEnfant;
    }

    /**
     * @param int $prix_enfant
     * @return Hotel
     */
    public function setPrixEnfant($prix_enfant)
    {
        $this->prixEnfant = $prix_enfant;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * @param mixed $ville
     * @return Hotel
     */
    public function setVille($ville)
    {
        $this->ville = $ville;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getReservations()
    {
        return $this->reservations;
    }

    /**
     * @param mixed $reservations
     * @return Hotel
     */
    public function setReservations($reservations)
    {
        $this->reservations = $reservations;
        return $this;
    }
}
