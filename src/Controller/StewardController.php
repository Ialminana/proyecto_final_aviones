<?php

namespace App\Controller;

use App\Entity\Steward;
use App\Repository\StewardRepository;
use App\Repository\FlightRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;

#[Route ('/api/steward', name: 'api_')]
class StewardController extends AbstractController
{

    public function __construct(private StewardRepository $stewardRepo, private FlightRepository $flightRepo)
    {}

    #[Route('/', name: 'app_steward', methods: ['get'])]
    public function index(ManagerRegistry $doctrine): JsonResponse
    {
        $stewards = $doctrine
            ->getRepository(steward::class)
            ->findAll();
        $data = [];

    foreach ($stewards as $steward) {
        $data[] = [
         'id' => $steward->getId(),
         'aircrew' => $steward->getAirCrewId(),
         'name' => $steward->getName(),
         'dni' => $steward->getDni(),
         'flight' => $steward->getFlight(),
            
        ];

    }

    return $this->json($data);
    }

    #[Route('/new', name: 'new_steward', methods:['post'])]
    public function create(Request $request): JsonResponse
    {
        $flight = $this->flightRepo->find($request->request->get('flight'));
        $steward = new Steward();
        $steward->setAirCrewId($request->request->get('aircrew'));
        $steward->setName($request->request->get('name'));
        $steward->setDni($request->request->get('dni'));
        $steward->setFlight($flight);
        
        $this->stewardRepo->save($steward,true);

           return $this->json([
            'steward' => $steward,
           ], 201);
    }

    #[Route('/update/{id}', name: 'update_steward', methods:['put', 'patch', 'post'])]
    public function update(ManagerRegistry $doctrine, Request $request, int $id): JsonResponse
    {
        $entityManager = $doctrine->getManager();
        $steward = $entityManager->getRepository(steward::class)->find($id);

        if (!$steward) {
            return $this->json('No steward found for id' . $id, 404);
        }
        
        $steward->setAirCrewId($request->request->get('aircrew'));
        $steward->setName($request->request->get('name'));
        $steward->setDni($request->request->get('dni'));
        $steward->setFlight($request->request->get('flightid'));
        
        $entityManager->flush();

        $data =  [
            'id' => $steward->getId(),
            'aircrew' => $steward->getAirCrewId(),
            'name' => $steward->getName(),
            'dni' => $steward->getDni(),
            'flight' => $steward->getFlight(),
              
           ];

        return $this->json($data);
    }

    #[Route('/show/{id}', name: 'show_steward', methods:['get'])]
    public function show(ManagerRegistry $doctrine, int $id): JsonResponse
    {
        $steward = $doctrine->getRepository(steward::class)->find($id);

        if(!$steward){
            return $this->json('No steward found for id ' . $id, 404);
        }

        $data =  [
            'id' => $steward->getId(),
            'aircrew' => $steward->getAirCrewId(),
            'name' => $steward->getName(),
            'dni' => $steward->getDni(),
            'flight' => $steward->getFlight(),
              
           ];

        return $this->json($data);
    }

    #[Route('/delete/{id}', name: 'delete_steward', methods:['delete'])]
    public function delete(ManagerRegistry $doctrine, int $id): JsonResponse
    {
        $entityManager = $doctrine->getManager();
        $steward = $entityManager->getRepository(steward::class)->find($id);

        if (!$steward) {
            return $this->json('No steward found for id ' . $id, 404);
        }

        $entityManager->remove($steward);
        $entityManager->flush();

        return $this->json('Deleted a steward succesfully with id ' . $id);
    }
}
