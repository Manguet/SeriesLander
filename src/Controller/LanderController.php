<?php

namespace App\Controller;

use App\Entity\Actor;
use App\Entity\Category;
use App\Entity\Episode;
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
     * @Route("/showProgram/{slug}", name="show_program")
     * @return Response
     */
    public function oneProgram($slug): Response
    {
        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy([
                'slug' => $slug,
            ]);

        $actors = $program->getActor();
        $seasons = $program->getSeasons();
        $numberOfSeasons = count($seasons);
        $category = $program->getCategory();

        return $this->render('lander/program.html.twig', [
            'program'           => $program,
            'actors'            => $actors,
            'seasons'           => $seasons,
            'number_of_seasons' => $numberOfSeasons,
            'category'          => $category,
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

    /**
     * @Route("/showByCategory/{slug}", name="by_category")
     */
    public function programByCategory($slug)
    {
        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findOneBy(['slug' => $slug]);

        $programs = $category->getPrograms();

        return $this->render('lander/byCategory.html.twig', [
            'category' => $category,
            'programs' => $programs,
        ]);
    }

    /**
     * @Route("/showByActor/{slug}", name="by_actor")
     */
    public function programByActor($slug)
    {
        $actor = $this->getDoctrine()
            ->getRepository(Actor::class)
            ->findOneBy(['slug' => $slug]);

        $programs = $actor->getPrograms();

        return $this->render('lander/byActor.html.twig', [
            'programs' => $programs,
            'actor'    => $actor,
        ]);
    }

    /**
     * @Route("/showEpisode/{slug}", name="episode")
     */
    public function episodeDetail($slug)
    {
        $episode = $this->getDoctrine()
            ->getRepository(Episode::class)
            ->findOneBy(['slug' => $slug]);

        $season = $episode->getSeason();

        return $this->render('lander/episode.html.twig', [
            'episode' => $episode,
            'season'  => $season,
        ]);
    }
}
