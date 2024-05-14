<?php

namespace App\Controller;


use App\Entity\CP;
use App\Entity\User;
use App\Entity\Commandes;
use App\Entity\Orders;
use App\Form\CommandesType;
use App\Entity\OrdersDetails;
use App\Repository\CPRepository;
use App\Repository\UserRepository;
use App\Repository\LivreRepository;
use App\Repository\CommandesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/commandes')]
class CommandesController extends AbstractController
{
    #[Route('/ajout', name: 'app_commandes_add')]
    public function add1(SessionInterface $session,LivreRepository $Lp,EntityManagerInterface $em) : Response 
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $panier = $session->get('panier',[]);
        if($panier==[])
        {
            $this->addFlash('message','Votre panier est vide');
            return $this->redirectToRoute('app_home');
        }
        $commande = new Orders();
        $total = 0;
        $commande->setUsers($this->getUser());
        foreach($panier as $item => $qte)
        {
            $orderDetails = new OrdersDetails();
            $livre  =  $Lp->find($item);
            $prix = $livre->getPrix();
            $orderDetails->setLivres($livre);
            $orderDetails->setPrix($prix);
            $orderDetails->setQte($qte);
            $total+= $prix*$qte;
            $commande->addOrdersDetail($orderDetails);


        }
        $commande->setTotal($total);
        $em->persist($commande);
        $em->flush();

        $session->remove('panier');

        $this->addFlash('message', 'Commande créée avec succès');
        return $this->redirectToRoute('checkout');
        }
   } 
