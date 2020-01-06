<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\SubUser;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\LoginFormAuthenticator;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }

    /**
     * @Route("/register", name="app_register")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param GuardAuthenticatorHandler $guardHandler
     * @param LoginFormAuthenticator $authenticator
     * @return Response
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, LoginFormAuthenticator $authenticator): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main'
            );
        }

        return $this->render('security/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/my-profil/{name}", name="app_profil")
     * @param $name
     * @param SessionInterface $session
     * @return Response
     */
    public function profile($name, SessionInterface $session)
    {
        $subUser = $this->getDoctrine()
            ->getRepository(SubUser::class)
            ->findOneBy(['name' => $name]);

        $user  = $subUser->getUser();
        $image = $subUser->getImage();

        $session->set('subUser', $subUser);

        return $this->render('security/profil.html.twig', [
            'subUser' => $subUser,
            'user'    => $user,
            'image'   => $image,
        ]);
    }

    /**
     * @Route("profil/edit", name="app_profil_edit")
     */
    public function profilEdit()
    {
        $images = $this->getDoctrine()
            ->getRepository(Image::class)
            ->findAll();

        return $this->render('security/images.html.twig', [
            'images' => $images,
        ]);
    }

    /**
     * @Route("profil/image/{id}", name="app_image_edit")
     * @param SessionInterface $session
     * @param $id
     * @return Response
     */
    public function editImage(SessionInterface $session, $id, EntityManagerInterface $manager, Request $request): Response
    {
        $subUser = $session->get('subUser');

        $newImage = $this->getDoctrine()
            ->getRepository(Image::class)
            ->find($id);

        $subUser->setImage($newImage);

        $manager->persist($subUser);
        $manager->flush();

        return $this->redirect($this->generateUrl('app_profil', [
            'name' => $subUser->getName(),
        ]));
    }
}
