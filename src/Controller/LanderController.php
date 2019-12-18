<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Program;
use App\Entity\Season;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
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
    public function allSeries(): Response
    {
        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findAll();

        return $this->render('lander/programs.html.twig', [
           'programs' => $programs,
        ]);
    }

    /**
     * @Route("/showProgram/{id}", name="show_program")
     * @param $id
     * @return Response
     */
    public function oneProgram($id): Response
    {
        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy([
                'id' => $id,
            ]);

        $actors = $program->getActor();
        $seasons = $program->getSeasons();
        $numberOfSeasons = count($seasons);

        return $this->render('lander/program.html.twig', [
            'program'           => $program,
            'actors'            => $actors,
            'seasons'           => $seasons,
            'number_of_seasons' => $numberOfSeasons,
        ]);
    }

    /**
     * @Route("/showSeason/{id}", name="show_season")
     * @param $id
     * @return Response
     */
    public function showBySeason($id): Response
    {
        $season = $this->getDoctrine()
            ->getRepository(Season::class)
            ->findOneBy([
                'id' => $id,
            ]);

        $program = $season->getProgram();

        return $this->render('lander/season.html.twig', [
            'season'  => $season,
            'program' => $program,
        ]);
    }
}
