<?php
/**
 * Created by PhpStorm.
 * User: nasolo
 * Date: 27/11/19
 * Time: 10:52
 */
namespace App\Controller;

use App\Form\Type\VilleType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class VilleController extends Controller
{

    /**
     *
     * @Route("/villes", name="ville_liste")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function liste(Request $request)
    {
        $client = HttpClient::create();
        $response = $client->request('GET', 'http://localhost:8001/villes');
        $villes = [];
        switch ($response->getStatusCode()) {
            case Response::HTTP_OK:
                $villes = $response->toArray();
                break;
        }
        return $this->render('ville/liste.html.twig', ['liste' => $villes]);
    }

    /**
     *  methods={"GET"}
     *
     * @Route("/villes/{id}", name="ville_detail")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function detail(Request $request)
    {
        $id = $request->get('id', 0);
        $client = HttpClient::create();
        $response = $client->request('GET', 'http://localhost:8001/villes/'.$id);
        $ville = $response->toArray();

        $request->query->add($ville);
        $request->request->add($ville);
        $form = $this->createForm(VilleType::class, null);
        $form->handleRequest($request);

        switch ($response->getStatusCode()) {
            case Response::HTTP_OK:
                $villes = $response->toArray();
                break;
        }
        return $this->render('ville/form.html.twig', ['formulaire' => $form->createView(), 'data' =>$ville]);
    }


    /**
     *  Enregister Ville edition
     *
     * @Route("/villes/{id}", name="ville_save", requirements={"id"="\d+"})
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function save(Request $request)
    {
        $id = $request->get('id', 0);
        $client = HttpClient::create();

        $form = $this->createForm(VilleType::class, null);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = new \stdClass();
            $data->id = $form->getData()['id'];
            $data->nom = $form->getData()['nom'];
            $response = $client->request(
                'PUT',
                'http://localhost:8001/villes/'.$id,
                [
                    'headers' => [
                        'Content-type' =>'application/json'
                    ],
                    'body' =>json_encode($data)
                ]
            );
            $ville = $response->toArray();
            switch ($response->getStatusCode()) {
                case Response::HTTP_OK:
                    $villes = $response->toArray();
                    return $this->redirectToRoute('ville_liste');
                    break;
            }
        }
        return $this->render('ville/form.html.twig', ['formulaire' => $form->createView(), 'data' =>$ville]);
    }


    /**
     *  Ajouter Ville
     *
     * @Route("/villes-ajout", name="ville_ajout")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function ajout(Request $request)
    {
        $id = $request->get('id', 0);
        $client = HttpClient::create();

        $form = $this->createForm(VilleType::class, null);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = new \stdClass();
            $data->id = $form->getData()['id'];
            $data->nom = $form->getData()['nom'];
            $response = $client->request(
                'POST',
                'http://localhost:8001/villes',
                [
                    'headers' => [
                        'Content-type' =>'application/json'
                    ],
                    'body' =>json_encode($data)
                ]
            );
            $ville = $response->toArray();
            switch ($response->getStatusCode()) {
                case Response::HTTP_OK:
                    $villes = $response->toArray();
                    break;
            }
        } else {
            return $this->render('ville/form.html.twig', ['formulaire' => $form->createView(), 'data' => null]);
        }

        return $this->redirectToRoute('ville_liste');
    }

    /**
     *  Ajouter Ville
     *
     * @Route("/villes-supprime/{id}", name="ville_supprime")
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
            'http://localhost:8001/villes/'.$id,
            [
                'headers' => [
                    'Content-type' =>'application/json'
                ],
                'body' =>'{}'
            ]
        );

        return $this->redirectToRoute('ville_liste');
    }
}