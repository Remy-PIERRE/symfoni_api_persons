<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class CategoryController extends AbstractController
{
    /**
     * @Route("/api/categories", name="getAllCategories", methods={"GET"})
     */
    public function getAll(CategoryRepository $categoryRepository, SerializerInterface $serializer): JsonResponse
    {
        $categories = $categoryRepository->findAll();

        $jsonCategories = $serializer->serialize($categories, 'json', ['groups' => 'getCategories']);

        return new JsonResponse($jsonCategories, Response::HTTP_OK, [], true);
    }

    /**
     * @Route("/api/categories/{id}", name="getOneCategory", methods={"GET"})
     */
    public function getOne(int $id, CategoryRepository $categoryRepository, SerializerInterface $serializer): JsonResponse
    {
        $category = $categoryRepository->find($id);

        if ($category) {
            $jsonCategory = $serializer->serialize($category, 'json', ['groups' => 'getCategories']);

            return new JsonResponse($jsonCategory, Response::HTTP_OK, [], true);
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }

    /**
     * @Route("/api/categories", name="addOneCategory", methods={"POST"})
     */
    public function addOne(Request $request, CategoryRepository $categoryRepository, SerializerInterface $serializer): JsonResponse
    {
        $category = $serializer->deserialize($request->getContent(), Category::class, 'json');

        $categoryRepository->add($category, true);

        $jsonCategory = $serializer->serialize($category, 'json');

        return new JsonResponse($jsonCategory, Response::HTTP_CREATED, [], true);
    }
}
