<?php

namespace App\Controller;

use App\Entity\Category;
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
    public function AllCategories()
    {
        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();

        return $this->render('lander/categories.html.twig', [
            'categories' => $categories,
        ]);
    }
}
