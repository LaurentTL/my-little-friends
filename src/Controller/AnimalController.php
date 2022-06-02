<?php

namespace App\Controller;

use App\Entity\Animal;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

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
    public function create(Request $request): Response
    {
        $animal = new Animal();
        $form = $this->createFormBuilder($animal)
            ->add('Nom')
            ->add('Type')
            ->add('Description')
            ->add('Photo')
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $animal = $form->getdata();
            var_dump($animal->getId());
            return $this->redirectToRoute('animal_show', ['id' => $animal->getId()]);
        }

        return $this->render('animal/create.html.twig', [
            'formAnimal' => $form->createView()
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
