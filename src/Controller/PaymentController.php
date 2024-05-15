<?php

namespace App\Controller;

use Stripe\Stripe;
use Stripe\Checkout\Session;
use Symfony\Component\Mime\Email;
use App\Repository\LivreRepository;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
#[IsGranted('ROLE_USER')]
class PaymentController extends AbstractController
{
    #[Route('/payment', name: 'app_payment')]
    public function index(): Response
    {
        return $this->render('payment/index.html.twig', [
            'controller_name' => 'PaymentController',
        ]);
    }

    #[Route('/checkout', name: 'checkout')]
    public function checkout(SessionInterface $ses,LivreRepository $Lp): Response
    {
        
        Stripe::setApiKey("sk_test_VePHdqKTYQjKNInc7u56JBrQ");
        $panier = $ses->get('panier', []);
        $t=[];
        foreach($panier as $item => $qte)
        {
            $livre  =  $Lp->find($item);
            $prix = $livre->getPrix();
            $t[] = [ // Append a new element to $t
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $livre->getTitre(),
                    ],
                    'unit_amount' => $prix,
                ],
                'quantity' => $qte,
            ];
            
        }
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items'           => [
                $t
            ],
            'mode'                 => 'payment',
            'success_url'          => $this->generateUrl('success_url', [], UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url'           => $this->generateUrl('cancel_url', [], UrlGeneratorInterface::ABSOLUTE_URL),
        ]);
        $ses->remove('panier');
        

        return $this->redirect($session->url, 303);
    }


    #[Route('/success-url', name: 'success_url')]
    public function successUrl(MailerInterface $mailer): Response
    {
        
        $email = (new Email())
            ->from('ademsansa7@gmail.com')
            ->to($this->getUser()->getUserIdentifier())
            ->subject('Commande Chez Symbooks')
            ->html('<p>Payement effectué avec succes : </p>');
        $mailer->send($email);
        return $this->render('payment/succes.html.twig', []);
    }


    #[Route('/cancel-url', name: 'cancel_url')]
    public function cancelUrl(): Response
    {
        return $this->render('payment/cancel.html.twig', []);
    }
}