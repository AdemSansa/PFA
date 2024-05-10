<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Repository\LivreRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    #[Route('/cart/index', name: 'cart_index')]
    public function index(SessionInterface $session,LivreRepository $LR): Response
    {
       
        $panier = $session->get('panier', []);
        
        $data =[];
        $total = 0 ;
        foreach ($panier as $id => $qte) {
            $livre = $LR->find($id);
            $data[] = [
                'livre' => $livre,
                'qte' => $qte
            ];
            $total += $livre->getPrix()*$qte;

        }
        return $this->render('cart/index.html.twig',compact('data','total'));
    }
    #[Route('/remove/{id}', name: 'cart_remove')]
    public function remove(Livre $livre, SessionInterface $session)
    {
        
        $id = $livre->getId();

  
        $panier = $session->get('panier', []);
        if(!empty($panier[$id])){
            if($panier[$id] > 1){
                $panier[$id]--;
            }else{
                unset($panier[$id]);
            }
        }

        $session->set('panier', $panier);
        
       
        return $this->redirectToRoute('cart_index');
    }
    #[Route('/delete/{id}', name: 'cart_delete')]
    public function delete(Livre $livre, SessionInterface $session)
    {
       
        $id = $livre->getId();

       
        $panier = $session->get('panier', []);

        if(!empty($panier[$id])){
            unset($panier[$id]);
        }

        $session->set('panier', $panier);
        return $this->redirectToRoute('cart_index');
    }







    #[Route('/cart/add/{id}', name: 'app_cart')]
    public function add($id, SessionInterface $session): Response
    {
        $panier = $session->get('panier', []);
        
        
        if(empty($panier[$id])){
            $panier[$id] = 1;
        }else{
            $panier[$id]++;
        }

        $session->set('panier', $panier);
        
      
        return $this->redirectToRoute('cart_index');
        
    }
    #[Route('/empty', name: 'cart_empty')]
    public function empty(SessionInterface $session)
    {
        $session->remove('panier');

        return $this->redirectToRoute('cart_index');
    }
}
