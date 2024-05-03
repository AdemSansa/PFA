<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Repository\LivreRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LivreController extends AbstractController
{
    #[Route('/livres', name: 'app_livre')]
    public function index(LivreRepository $rep ): Response
    {
        $livres = $rep->findAll(); 
        
        return $this->render('livre/index.html.twig', [
            'livres' => $livres,
        ]);
    }
    #[Route('/livre/ShowDetail/{id}', name: 'app_livre_detail')]
    public function detail(LivreRepository $rep,$id ): Response
    {
        $detail = $rep->find($id); 
        //dd($detail);
        return $this->render('livre/detail.html.twig', [
            'detail' => $detail,
        ]);
    }

    #[Route('/livre/create', name: 'app_livre_create')]
    public function create(EntityManagerInterface $em ): Response
    {
        $livre = new Livre();
        $livre->setImage('https://fastly.picsum.photos/id/795/300/300.jpg?hmac=2TvOfAO705eFXCltJc0iKEtkTUnky34Icq3jKNBXK1Q');
        $livre->setTitre('Titre de livre 5');
        $livre->setEditeur('editeur 5 ');
        $livre->setISBN('1111-1111-111-1111-');
        $livre->setPrix(200);
        $livre->setEditedAt(new  \DateTimeImmutable('01-01-2024'));
        $livre->setSlug('titre-du-livre-5');
        $livre->setResume('dazdazfdezdaazdazdazadadad');
        $em->persist($livre);
        $em->flush();
        //dd($livre);
        return $this->redirectToRoute('app_livre');
        
    }
    #[Route('/livre/delete/{id}', name: 'app_livre_delete')]
    public function supprimer(Livre $livre, EntityManagerInterface $em): Response
    {
    $em->remove($livre);
    $em->flush();
    return $this->redirectToRoute('app_livre');
    }
}
