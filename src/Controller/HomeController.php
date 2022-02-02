<?php

namespace App\Controller;

use App\Entity\Category;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

    /**
     * @Route("default/navbar", name="navbar")
     */
    public function navbar(ManagerRegistry $managerRegistry)
    {
        $entityManager = $managerRegistry->getRepository(Category::class);
        return $this->render('components/_navbar.html.twig', [
            'categories' => $entityManager->findAll(),
        ]);
    }
}
