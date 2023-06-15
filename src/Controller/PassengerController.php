<?php

namespace App\Controller;

use App\Entity\Passenger;
use App\Repository\PassengerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;

#[Route ('api/passenger', name: 'api_')]
class PassengerController extends AbstractController
{
     public function __construct(private PassengerRepository $passengerRepo)
    {}
    
    #[Route('/', name: 'app_passenger', methods: ['get'])]
    public function index(ManagerRegistry $doctrine): JsonResponse
    {
        $passengers = $doctrine
            ->getRepository(passenger::class)
            ->findAll();
        $data = [];

    foreach ($passengers as $passenger) {
        $data[] = [
         'id' => $passenger->getId(),
         'seat' => $passenger->getSeat(),
         'name' => $passenger->getName(),
         'dni' => $passenger->getDni(),
            
        ];

    }
    return $this->json($data);
    }

    #[Route('/new', name: 'new_passenger', methods:['post'])]
    public function create(Request $request): JsonResponse
    {
        $passenger = new Passenger();
        $passenger->setSeat($request->request->get('seat'));
        $passenger->setName($request->request->get('name'));
        $passenger->setDni($request->request->get('dni'));
        
        $this->passengerRepo->save($passenger,true);

           return $this->json([
            'passenger' => $passenger,
           ], 201);
    }

    #[Route('/update/{id}', name: 'update_passenger', methods:['put', 'patch', 'post'])]
    public function update(ManagerRegistry $doctrine, Request $request, int $id): JsonResponse
    {
        $entityManager = $doctrine->getManager();
        $passenger = $entityManager->getRepository(passenger::class)->find($id);

        if (!$passenger) {
            return $this->json('No passenger found for id' . $id, 404);
        }
        
        $passenger->setSeat($request->request->get('seat'));
        $passenger->setName($request->request->get('name'));
        $passenger->setDni($request->request->get('dni'));
        
        $entityManager->flush();

        $data =  [
            'id' => $passenger->getId(),
            'seat' => $passenger->getSeat(),
            'name' => $passenger->getName(),
            'dni' => $passenger->getDni(),
              
           ];

        return $this->json($data);
    }

    #[Route('/show/{id}', name: 'show_passenger', methods:['get'])]
    public function show(ManagerRegistry $doctrine, int $id): JsonResponse
    {
        $passenger = $doctrine->getRepository(passenger::class)->find($id);

        if(!$passenger){
            return $this->json('No passenger found for id ' . $id, 404);
        }

        $data = [
            'id' => $passenger->getId(),
            'seat' => $passenger->getSeat(),
            'name' => $passenger->getName(),
            'dni' => $passenger->getDni(),
             
        ];

        return $this->json($data);
    }

    #[Route('/delete/{id}', name: 'delete_passenger', methods:['delete'])]
    public function delete(ManagerRegistry $doctrine, int $id): JsonResponse
    {
        $entityManager = $doctrine->getManager();
        $passenger = $entityManager->getRepository(passenger::class)->find($id);

        if (!$passenger) {
            return $this->json('No passenger found for id ' . $id, 404);
        }

        $entityManager->remove($passenger);
        $entityManager->flush();

        return $this->json('Deleted a passenger succesfully with id ' . $id);
    }

}