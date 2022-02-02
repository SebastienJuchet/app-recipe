<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Form\RecipeType;
use App\Repository\RecipeRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/recette", name="recipe_")
 */
class RecipeController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(RecipeRepository $recipeRepository): Response
    {
        return $this->render('recipe/index.html.twig', [
            'recipes' => $recipeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/creer", name="new")
     */
    public function new(Request $request, ManagerRegistry $managerRegistry): Response
    {
        $recipe = new Recipe();
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $recipe->setUser($this->getUser());
            $managerRegistry->getManager()->persist($recipe);
            $managerRegistry->getManager()->flush();
            $this->addFlash('success', 'Recette bien enregistrée');
            return $this->redirectToRoute('recipe_index');
        }

        return $this->renderForm('recipe/new.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit")
     */
    public function edit(Recipe $recipe, Request $request, ManagerRegistry $managerRegistry): Response
    {
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $managerRegistry->getManager()->flush();
            $this->addFlash('success', 'Recette bien modifiée');
            return $this->redirectToRoute('recipe_index');
        }
        return $this->renderForm('recipe/edit.html.twig', [
            'form' => $form
        ]);
    }

    /**
     * @Route("/{id}", name="show")
     */
    public function show(Recipe $recipe): Response
    {
        return $this->render('recipe/show.html.twig', [
            'recipe' => $recipe,
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(Recipe $recipe, ManagerRegistry $managerRegistry): Response
    {
        $managerRegistry->getManager()->remove($recipe);
        $managerRegistry->getManager()->flush();
        $this->addFlash('danger', 'La recette à bien été supprimée!');
        return $this->redirectToRoute('recipe_index');
    }
}
