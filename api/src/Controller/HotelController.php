<?php
/**
 * Created by PhpStorm.
 * User: nasolo
 * Date: 27/11/19
 * Time: 10:52
 */
namespace App\Controller;

use App\Entity\Hotel;
use App\Form\Type\VilleType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HotelController extends Controller
{

    /**
     *
     * @Route("/hotels-par-ville/{id}", name="liste_hotel_ville")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function hotelParVille(Request $request)
    {
        $listeHotel = $this->getDoctrine()->getRepository(Hotel::class)->findByVille($request->get('id'));
        $data = [];
        /** @var Hotel $hotel */
        foreach ($listeHotel as $hotel) {
            $h = new \stdClass();
            $h->id = $hotel->getId();
            $h->nom = $hotel->getNom();
            $h->ville_id = $hotel->getVille()->getId();
            $h->ville_nom = $hotel->getVille()->getNom();
            array_push($data, $h);
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }
}