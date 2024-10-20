<?php

namespace App\Controller\Admin;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/book')]
class BookController extends AbstractController
{
    #[Route('/', name: 'app_admin_book_index')]
    public function index(BookRepository $repository): Response
    {
        $books = $repository->findAll();

        return $this->render('admin/book/index.html.twig', [
            'books' => $books,
        ]);
    }

    #[IsGranted('ROLE_AJOUT_DE_LIVRE')]
    #[Route('/new', name: 'app_admin_book_new', methods:['GET', 'POST'])]
    #[Route('/{id}/edit', name: 'app_admin_book_edit',  requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function new(?Book $book, Request $request, EntityManagerInterface $manager): Response
    {

        if($book){
            $this->denyAccessUnlessGranted('ROLE_EDITION_DE_LIVRE');
        }

        $book ??= new Book();
        $form = $this->createForm(BookType::class, $book);
        
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist(($book));
            $manager->flush();

            return $this->redirectToRoute('app_admin_book_index');
        }

        return $this->render('admin/book/new.html.twig', [
            'form' => $form,
        ]);
    }

}
