<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/admin/user')]
class RegistrationController extends AbstractController
{
    #[Route('/', name: 'app_admin_user_index')]
    public function index(UserRepository $repository): Response
    {
        $users = $repository->findAll();

        return $this->render('admin/user/index.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/new', name: 'app_admin_user_new')]
    #[Route('/{id}/edit', name: 'app_admin_user_edit',  requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function register(?User $user, Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        if(null === $user){
            $this->denyAccessUnlessGranted('ROLE_ADMIN');
        }
        
        $user ??= new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // TODO : if edit user, dont ask for password

            /** @var string $plainPassword */
            $plainPassword = $form->get('plainPassword')->getData();

            // encode the plain password
            $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_user_index');
        }

        return $this->render('admin/user/registration.html.twig', [
            'registrationForm' => $form,
        ]);
    }
}
