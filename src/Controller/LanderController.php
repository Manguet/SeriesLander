<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Program;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/lander", name="lander_")
 */
class LanderController extends AbstractController
{
    /**
     * @Route("/categories", name="categories")
     */
    public function allCategories()
    {
        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();

        return $this->render('lander/categories.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/series", name="series")
     */
    public function allSeries()
    {
        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findAll();

        return $this->render('lander/programs.html.twig', [
           'programs' => $programs,
        ]);
    }
}
