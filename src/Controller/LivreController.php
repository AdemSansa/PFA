<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Form\LivreType;
use Doctrine\ORM\EntityManager;
use App\Repository\LivreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
#[IsGranted('ROLE_ADMIN')]
class LivreController extends AbstractController
{
    #[Route('/admin/livres', name: 'app_livre')]
    public function index(LivreRepository $rep ): Response
    {
        $livres = $rep->findAll(); 
        
        return $this->render('livre/index.html.twig', [
            'livres' => $livres,
        ]);
    }
    #[Route('/admin/livre/ShowDetail/{id}', name: 'app_livre_detail')]
    public function detail(LivreRepository $rep,$id ): Response
    {
        $detail = $rep->find($id); 
        //dd($detail);
        return $this->render('livre/detail.html.twig', [
            'detail' => $detail,
        ]);
    }

    #[Route('/admin/livre/create', name: 'app_livre_create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $livre = new Livre();
        $form = $this->createForm(LivreType::class, $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($livre);
            $entityManager->flush();

            return $this->redirectToRoute('app_livre', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('livre/new.html.twig', [
            'livre' => $livre,
            'form' => $form,
        ]);
        
    }
    #[Route('/admin/livre/delete/{id}', name: 'app_livre_delete')]
    public function supprimer(Livre $livre, EntityManagerInterface $em): Response
    {
    $em->remove($livre);
    $em->flush();
    return $this->redirectToRoute('app_livre');
    }
}
