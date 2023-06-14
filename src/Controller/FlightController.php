<?php

namespace App\Controller;

use App\Entity\Flight;
use App\Repository\FlightRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route ('/api/flight', name: 'api_')]
class FlightController extends AbstractController
{

    public function __construct(private FlightRepository $flightRepo)
    {}

    #[Route('/', name: 'app_flight', methods: ['get'])]
    public function index(ManagerRegistry $doctrine): JsonResponse
    {
        $flights = $doctrine
            ->getRepository(Flight::class)
            ->findAll();
        $data = [];

        foreach ($flights as $flight) {
            $data[] = [
             'id' => $flight->getId(),
             'number' => $flight->getNumber(),
             'departs' => $flight->getDepartsFrom(),
             'arrives' => $flight->getArrivesTo(),   
            ];

        }

        return $this->json($data);
    }

    #[Route('/new', name: 'new_flight', methods:['post'])]
    public function create(Request $request): JsonResponse
    {
        $flight = new Flight();
        $flight->setNumber($request->request->get('number'));
        $flight->setDepartsFrom($request->request->get('departs'));
        $flight->setArrivesTo($request->request->get('arrives'));

        $this->flightRepo->save($flight,true);

       
           return $this->json([
            'flight' => $flight,
           ], 201);
    }

    #[Route('/update/{id}', name: 'update_flight', methods:['put', 'patch', 'post'])]
    public function update(ManagerRegistry $doctrine, Request $request, int $id): JsonResponse
    {
        $entityManager = $doctrine->getManager();
        $flight = $entityManager->getRepository(Flight::class)->find($id);

        if (!$flight) {
            return $this->json('No flight found for id' . $id, 404);
        }
        
        $flight->setNumber($request->request->get('number'));
        $flight->setDepartsFrom($request->request->get('departs'));
        $flight->setArrivesTo($request->request->get('arrives'));
        $entityManager->flush();

        $data =  [
            'id' => $flight->getId(),
            'number' => $flight->getNumber(),
            'departs' => $flight->getDepartsFrom(),
            'arrives' => $flight->getArrivesTo(),   
           ];

        return $this->json($data);
    }

    #[Route('/show/{id}', name: 'show_flight', methods:['get'])]
    public function show(ManagerRegistry $doctrine, int $id): JsonResponse
    {
        $flight = $doctrine->getRepository(Flight::class)->find($id);

        if(!$flight){
            return $this->json('No flight found for id ' . $id, 404);
        }

        $data = [
            'id' => $flight->getId(),
            'number' => $flight->getNumber(),
            'departs' => $flight->getDepartsFrom(),
            'arrives' => $flight->getArrivesTo(), 
        ];

        return $this->json($data);
    }

    #[Route('/delete/{id}', name: 'delete_flight', methods:['delete'])]
    public function delete(ManagerRegistry $doctrine, int $id): JsonResponse
    {
        $entityManager = $doctrine->getManager();
        $flight = $entityManager->getRepository(Flight::class)->find($id);

        if (!$flight) {
            return $this->json('No flight found for id ' . $id, 404);
        }

        $entityManager->remove($flight);
        $entityManager->flush();

        return $this->json('Deleted a flight succesfully with id ' . $id);
    }

}
