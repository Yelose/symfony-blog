<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Usuario;

#[Route('/api', name: 'api_')]
class UsuarioController extends AbstractController
{
    #[Route('/usuarios', name: 'mostrar-usuarios', methods: ["GET"])]
    public function index(ManagerRegistry $doctrine): JsonResponse
    {
        $usuarios = $doctrine->getRepository(Usuario::class)->findAll();
        $data = [];

        foreach ($usuarios as $user) {
            $data[] = [
                "id" => $user->getId(),
                "nombre" => $user->getNombre()
            ];
        }
        return $this->json($data);
    }

    #[Route('/usuario', name: 'crear-usuario', methods: ['POST'])]
    public function addUser(ManagerRegistry $doctrine, Request $request): JsonResponse
    {
        $entityManager = $doctrine->getManager();

        $data = $request->toArray();

        $usuario = new Usuario();
        $usuario->setNombre($data["nombre"]);

        $entityManager->persist($usuario);
        $entityManager->flush();

        $response = [
            'id' => $usuario->getId(),
            'nombre' => $usuario->getNombre(),
        ];

        return $this->json($response, JsonResponse::HTTP_CREATED);
    }
}