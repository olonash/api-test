<?php
/**
 * Created by PhpStorm.
 * User: nasolo
 * Date: 14/12/19
 * Time: 10:59
 */

namespace App\Services;


use App\Form\Type\VilleType;
use App\Service\MessageGenerator;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Response;

class VilleService
{
    /**
     * @var ContainerInterface
     */
    protected $container;
    /**
     * VilleService constructor.
     * @param MessageGenerator $mg
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        return $this;
    }

    /**
     * @return array
     */
    public function liste ()
    {
        $client = HttpClient::create();
        $response = $client->request('GET', 'http://localhost:8001/villes');
        $villes = [];
        switch ($response->getStatusCode()) {
            case Response::HTTP_OK:
                $villes = $response->toArray();
                break;
        }
        return $villes;
    }

    /**
     * @param int $id
     */
    public function detail (int $id)
    {
        $client = HttpClient::create();
        $response = $client->request('GET', 'http://localhost:8001/villes/'.$id);

        $ville = [];

        switch ($response->getStatusCode()) {
            case Response::HTTP_OK:
                $ville = $response->toArray();
                break;
        }

        return $ville;
    }
}