<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/", name="app_")
 */
class DefaultController extends AbstractController
{
    /**
     * @Route("", name="index")
     */
    public function index()
    {
        $user = $this->getUser();
        $subUsers = null;
        if ($user != null) {
            $subUsers = $user->getSubUsers();
        }

        return $this->render('index.html.twig', [
            'subUsers' => $subUsers,
        ]);
    }
}
