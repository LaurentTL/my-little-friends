<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Form\AnimalType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AnimalController extends AbstractController
{
    #[Route('/animal', name: 'app_animal')]
    public function index(EntityManagerInterface $em): Response
    {
        $repo = $em->getRepository(Animal::class);

        $animals = $repo->findAll();

        return $this->render('animal/index.html.twig', [
            'controller_name' => 'AnimalController',
            'animals' => $animals
        ]);
    }

    #[Route('/animal/new', name: 'animal_create')]
    #[Route('/animal/{id}/edit', name: 'animal_edit')]
    public function form(Int $id = null, EntityManagerInterface $em, Request $request): Response
    {
        if (!$id) {
            $animal = new Animal();
        } else {
            $animal = $em->getRepository(Animal::class)->find($id);
        }

        $form = $this->createForm(AnimalType::class, $animal);

        // var_dump($form);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $animal = $form->getdata();

            $em->persist($animal);
            $em->flush();
            return $this->redirectToRoute('animal_show', ['id' => $animal->getId()]);
        }

        return $this->render('animal/create.html.twig', [
            'formAnimal' => $form->createView(),
            'editMode' => $animal->getId() !== null
        ]);
    }

    #[Route('/animal/{id}', name: 'animal_show')]
    public function show(EntityManagerInterface $em, $id)
    {
        $repo = $em->getRepository(Animal::class);
        $animal = $repo->find($id);
        return $this->render('/animal/show.html.twig', [
            'animal' => $animal
        ]);
    }
}
