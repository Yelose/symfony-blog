<?php

namespace App\Controller;

use App\Entity\Articulo;
use App\Entity\Categoria;
use App\Entity\Usuario;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

#[Route('/api', name: 'api_')]
class ArticuloController extends AbstractController
{
    #[Route('/articulo', name: 'crear-articulo', methods: ["POST"])]
    public function addArticulo(ManagerRegistry $doctrine, Request $request): JsonResponse
    {
        $entityManager = $doctrine->getManager();

        $data = $request->toArray();

        $usuarioId = $data["usuario"];
        $categoriaIds = $data["categorias"];

        $usuario = $entityManager->getRepository(Usuario::class)->find($usuarioId);
        $categorias = $entityManager->getRepository(Categoria::class)->find($categoriaIds);
        $categoriasCollection = new ArrayCollection();

        foreach ($categorias as $categoria) {
            $categoriasCollection->add($categoria);
        }
        $entityManager->getRepository(Categoria::class)->find($categoriaIds);

        // Crear un nuevo artículo y asignarle el usuario y las categorías
        $articulo = new Articulo();
        $articulo->setUsuario($usuario);
        $articulo->setCategorias($categoriasCollection);
        $articulo->setTitulo($data["titulo"]);
        $articulo->setContenido($data["contenido"]);

        $entityManager->persist($articulo);
        $entityManager->flush();

        $response = [
            'id' => $articulo->getId(),
            'titulo' => $articulo->getTitulo(),
            'contenido' => $articulo->getContenido(),
            'usuario' => [
                'id' => $usuario->getId(),
                'nombre' => $usuario->getNombre()
            ],
            'categorias' => array_map(function (Categoria $categoria) {
                return [
                    'id' => $categoria->getId(),
                    'nombre' => $categoria->getNombre()
                ];
            }, $categorias)
        ];

        return $this->json($response, JsonResponse::HTTP_CREATED);
    }
}