<?php
/**
 * Created by PhpStorm.
 * User: nasolo
 * Date: 27/11/19
 * Time: 10:52
 */
namespace App\Controller;

use App\Form\Type\HotelType;
use App\Form\Type\VilleType;
use App\Services\VilleService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HotelController extends Controller
{
    /**
     *
     * @Route("/hotels", name="hotel_liste")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function liste(Request $request)
    {
        $client = HttpClient::create();
        $response = $client->request('GET', 'http://localhost:8001/hotels');
        $hotels = [];
        switch ($response->getStatusCode()) {
            case Response::HTTP_OK:
                $hotels = $response->toArray();
                break;
        }
        return $this->render('hotel/liste.html.twig', ['liste' => $hotels]);
    }

    /**
     *
     * @Route("/hotels/{id}", name="hotel_detail")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function detail(Request $request)
    {
        $id = $request->get('id', 0);
        $client = HttpClient::create();
        $response = $client->request('GET', 'http://localhost:8001/hotels/'.$id);
        $form = $this->createForm(HotelType::class, null);

        switch ($response->getStatusCode()) {
            case Response::HTTP_OK:
                $hotel = $response->toArray();
                break;
        }
        return $this->render('hotel/form.html.twig', ['formulaire' => $form->createView(), 'data' =>$hotel]);
    }


    /**
     *  Enregister Ville edition
     *
     * @Route("/villes/{id}", name="hotel_save", requirements={"id"="\d+"})
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function save(Request $request)
    {
        $id = $request->get('id', 0);
        $client = HttpClient::create();

        $form = $this->createForm(HotelType::class, null);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //preparation données
            $data = new \stdClass();
            $data->id = $form->getData()['id'];
            $data->nom = $form->getData()['nom'];
            $data->ville = $form->getData()['ville'];
            $data->prixAdulte = $form->getData()['prixAdulte'];
            $data->prixEnfant = $form->getData()['prixEnfant'];
            $response = $client->request(
                'PUT',
                'http://localhost:8001/hotels/'.$id,
                [
                    'headers' => [
                        'Content-type' =>'application/json'
                    ],
                    'body' =>json_encode($data)
                ]
            );
            $ville = [];
            switch ($response->getStatusCode()) {
                case Response::HTTP_OK:
                    $ville = $response->toArray();
                    return $this->redirectToRoute('hotel_liste');
                    break;
            }
        }
        return $this->render('hotel/form.html.twig', ['formulaire' => $form->createView(), 'data' =>$form->getNormData()]);
    }


    /**
     *  Ajout hotel
     *
     * @Route("/hotels-ajout", name="hotel_ajout")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function ajout(Request $request, VilleService $villeService)
    {
        $id = $request->get('id', 0);
        $client = HttpClient::create();

        $form = $this->createForm(HotelType::class, null);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //preparation données
            $data = new \stdClass();
            $data->id = $form->getData()['id'];
            $data->nom = $form->getData()['nom'];
            $data->ville = $form->getData()['ville'];
            $data->prixAdulte = $form->getData()['prixAdulte'];
            $data->prixEnfant = $form->getData()['prixEnfant'];
            //envoi requete
            $response = $client->request(
                'POST',
                'http://localhost:8001/hotels',
                [
                    'headers' => [
                        'Content-type' =>'application/json'
                    ],
                    'body' =>json_encode($data)
                ]
            );
        } else {
            $response = $client->request('GET', 'http://localhost:8001/hotels');
            $villes = [];
            switch ($response->getStatusCode()) {
                case Response::HTTP_OK:
                    $villes = $response->toArray();
                    break;
            }
            return $this->render(
                'hotel/form.html.twig',
                [
                    'formulaire' => $form->createView(),
                    'data' => null,
                    'villes' => $villes
                ]
            );
        }

        return $this->redirectToRoute('hotel_liste');
    }

    /**
     *  Ajouter Ville
     *
     * @Route("/hotels-supprime/{id}", name="hotel_supprime")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function supprime(Request $request)
    {
        $id = $request->get('id', 0);
        $client = HttpClient::create();

        $form = $this->createForm(VilleType::class, null);
        $form->handleRequest($request);

        $response = $client->request(
            'DELETE',
            'http://localhost:8001/hotels/'.$id,
            [
                'headers' => [
                    'Content-type' =>'application/json'
                ],
                'body' =>'{}'
            ]
        );

        return $this->redirectToRoute('hotel_liste');
    }
}