<?php

namespace App\Controller;

use App\Entity\Person;
use App\Repository\CategoryRepository;
use App\Repository\PersonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class PersonController extends AbstractController
{
    /**
     * @Route("/api/persons", name="getAllPersons", methods={"GET"})
     */
    public function getAll(PersonRepository $personRepository, SerializerInterface $serializer): JsonResponse
    {
        $persons = $personRepository->findAll();
        $jsonPersons = $serializer->serialize($persons, 'json', ["groups" => "group1"]);

        return new JsonResponse($jsonPersons, Response::HTTP_OK, [], true);
    }

    /**
     * @Route("/api/persons/{id}", name="getOnePerson", methods={"GET"})
     */
    public function getOne(int $id, PersonRepository $personRepository, SerializerInterface $serializer): JsonResponse
    {
        $person = $personRepository->find($id);

        if ($person) {
            $jsonPerson = $serializer->serialize($person, 'json', ['groups' => 'group1']);

            return new JsonResponse($jsonPerson, Response::HTTP_OK, [], true);
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }

    /**
     * @Route("/api/persons", name="addOnePerson", methods={"POST"})
     */
    public function addOne(Request $request, PersonRepository $personRepository, CategoryRepository $categoryRepository, SerializerInterface $serializer): JsonResponse
    {
        $person = $serializer->deserialize($request->getContent(), Person::class, 'json');

        $content = $request->toArray();
        $cateogory_id = $content['category_id'];
        $category = $categoryRepository->find($cateogory_id);

        $person->setCategory($category);
        $personRepository->add($person, true);

        $jsonPerson = $serializer->serialize($person, 'json', ['groups' => 'group1']);

        return new JsonResponse($jsonPerson, Response::HTTP_CREATED, [], true);
    }

    /**
     * @Route("/api/persons/{id}", name="removeOnePerson", methods={"DELETE"})
     */
    public function removeOne(int $id, PersonRepository $personRepository, SerializerInterface $serializer): JsonResponse
    {
        $person = $personRepository->find($id);

        $personRepository->remove($person, true);

        return new JsonResponse(null, Response::HTTP_OK);
    }
}
