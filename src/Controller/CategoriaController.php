<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Categoria;

#[Route('/api', name: 'api_')]
class CategoriaController extends AbstractController
{
    #[Route('/categorias', name: 'mostrar-categorias', methods: ["GET"])]
    public function index(ManagerRegistry $doctrine): JsonResponse
    {
        $categorias = $doctrine->getRepository(Categoria::class)->findAll();

        $data = [];

        foreach ($categorias as $categoria) {
            $data[] = [
                "id" => $categoria->getId(),
                "nombre" => $categoria->getNombre()
            ];
        }

        return $this->json($data);
    }

    #[Route('/categoria', name: 'crear-categoria', methods: ['POST'])]
    public function addCategoria(ManagerRegistry $doctrine, Request $request): JsonResponse
    {
        $entityManager = $doctrine->getManager();

        $data = $request->toArray();

        $categoria = new Categoria();
        $categoria->setNombre($data["nombre"]);

        $entityManager->persist($categoria);
        $entityManager->flush();

        $response = [
            'id' => $categoria->getId(),
            'nombre' => $categoria->getNombre(),
        ];

        return $this->json($response, JsonResponse::HTTP_CREATED);
    }

}