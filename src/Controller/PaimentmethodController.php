<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PaimentmethodController extends AbstractController
{
    #[Route('/paimentmethod', name: 'app_paimentmethod')]
    public function index(): Response
    {
        return $this->render('paimentmethod/index.html.twig', [
            'controller_name' => 'PaimentmethodController',
        ]);
    }

    #[Route('/modepaiment', name: 'app_modepaiment')]
    public function modepaiment(Request $request): Response
    {
        $selectedPayment = $request->request->get('modePaiement');
        if($selectedPayment==="Paiement à la livraison"){
            return $this->render('payment/succe.html.twig'
        );
            
        }
        else{
            return $this->redirectToRoute('checkout');
        }
        
    }



}
