<?php

namespace App\Controller;

use App\Entity\SubUser;
use App\Form\SubUserType;
use App\Repository\SubUserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/subUser", name="sub_user_")
 */
class SubUserController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(SubUserRepository $subUserRepository): Response
    {
        return $this->render('sub_user/index.html.twig', [
            'sub_users' => $subUserRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $subUser = new SubUser();
        $form = $this->createForm(SubUserType::class, $subUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($subUser);
            $entityManager->flush();

            return $this->redirectToRoute('sub_user_index');
        }

        return $this->render('sub_user/new.html.twig', [
            'sub_user' => $subUser,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(SubUser $subUser): Response
    {
        return $this->render('sub_user/show.html.twig', [
            'sub_user' => $subUser,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, SubUser $subUser): Response
    {
        $form = $this->createForm(SubUserType::class, $subUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sub_user_index');
        }

        return $this->render('sub_user/edit.html.twig', [
            'sub_user' => $subUser,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(Request $request, SubUser $subUser): Response
    {
        if ($this->isCsrfTokenValid('delete'.$subUser->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($subUser);
            $entityManager->flush();
        }

        return $this->redirectToRoute('sub_user_index');
    }
}
