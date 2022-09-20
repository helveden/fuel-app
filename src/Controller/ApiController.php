<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

use App\Cleaner\Pdv\UseCase as PdvUseCase;

/**
 * @Route("/api")
 */
class ApiController extends AbstractController
{
    /**
     * @Route("/", name="app_api_default")
     */
    public function index(): JsonResponse {
        return $this->json([]);
    }

    /**
     * @Route("/pdv", name="app_api_pdv")
     */
    public function indexPdv(PdvUseCase $pdvUseCase): JsonResponse {
        return $this->json($pdvUseCase->getAll());
    }
    
    /**
     * @Route("/pdv/{id}", name="app_api_pdv_one")
     */
    public function showPdv(PdvUseCase $pdvUseCase, $id): JsonResponse {
        
        return $this->json($pdvUseCase->get($id));
    }
    
    /**
     * @Route("/search-pdv/{city}", name="app_api_search_pdv")
     */
    public function searchPdv(PdvUseCase $pdvUseCase, $city = null): JsonResponse {
        
        $params = [
            // 'cp' => '77500',
            'city' => $city
            // 'distance' => '12' > recherche avec un rayon
        ];
        return $this->json($pdvUseCase->searchBy($params));
    }
}
