<?php

namespace App\Controller;
use App\Entity\Captain;
use App\Entity\Person;
use App\Repository\CaptainRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;

#[Route ('api/captain', name: 'api_')]
class CaptainController extends AbstractController
{

    public function __construct(private CaptainRepository $captainRepo)
    {}

    #[Route('/', name: 'app_captain', methods: ['get'])]
    public function index(ManagerRegistry $doctrine): JsonResponse
    {
        $captains = $doctrine
            ->getRepository(Captain::class)
            ->findAll();
        $data = [];

    foreach ($captains as $captain) {
        $data[] = [
         'id' => $captain->getId(),
         'license' => $captain->getCaptainLicenseId(),
         'name' => $captain->getName(),
         'dni' => $captain->getDni(),
         
            
        ];

    }

    return $this->json($data);
    }

    #[Route('/new', name: 'new_captain', methods:['post'])]
    public function create(Request $request): JsonResponse
    {
        $captain = new Captain();
        $captain->setCaptainLicenseId($request->request->get('license'));
        $captain->setName($request->request->get('name'));
        $captain->setDni($request->request->get('dni'));
        
        $this->captainRepo->save($captain,true);

           return $this->json([
            'captain' => $captain,
           ], 201);
    }

    #[Route('/update/{id}', name: 'update_captain', methods:['put', 'patch', 'post'])]
    public function update(ManagerRegistry $doctrine, Request $request, int $id): JsonResponse
    {
        $entityManager = $doctrine->getManager();
        $captain = $entityManager->getRepository(captain::class)->find($id);

        if (!$captain) {
            return $this->json('No captain found for id' . $id, 404);
        }
        
        $captain->setCaptainLicenseId($request->request->get('license'));
        $captain->setName($request->request->get('name'));
        $captain->setDni($request->request->get('dni'));
        
        $entityManager->flush();

        $data =  [
            'id' => $captain->getId(),
            'license' => $captain->getCaptainLicenseId(),
            'name' => $captain->getName(),
            'dni' => $captain->getDni(),
              
           ];

        return $this->json($data);
    }

    #[Route('/show/{id}', name: 'show_captain', methods:['get'])]
    public function show(ManagerRegistry $doctrine, int $id): JsonResponse
    {
        $captain = $doctrine->getRepository(captain::class)->find($id);

        if(!$captain){
            return $this->json('No captain found for id ' . $id, 404);
        }

        $data = [
            'id' => $captain->getId(),
            'license' => $captain->getCaptainLicenseId(),
            'name' => $captain->getName(),
            'dni' => $captain->getDni(),
             
        ];

        return $this->json($data);
    }

    #[Route('/delete/{id}', name: 'delete_captain', methods:['delete'])]
    public function delete(ManagerRegistry $doctrine, int $id): JsonResponse
    {
        $entityManager = $doctrine->getManager();
        $captain = $entityManager->getRepository(captain::class)->find($id);

        if (!$captain) {
            return $this->json('No captain found for id ' . $id, 404);
        }

        $entityManager->remove($captain);
        $entityManager->flush();

        return $this->json('Deleted a captain succesfully with id ' . $id);
    }
}
