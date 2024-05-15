<?php

namespace App\Controller;


use App\Entity\CP;
use App\Entity\User;
use App\Entity\Orders;
use App\Entity\Commandes;
use App\Form\CommandesType;
use App\Entity\OrdersDetails;
use App\Repository\CPRepository;
use Symfony\Component\Mime\Email;
use App\Repository\UserRepository;
use App\Repository\LivreRepository;
use App\Repository\CommandesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/commandes')]
class CommandesController extends AbstractController
{
    #[Route('/ajout', name: 'app_commandes_add')]
    public function add1(SessionInterface $session,LivreRepository $Lp,EntityManagerInterface $em ,MailerInterface $mailer) : Response 
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
        $text = "<table class='table'>
        <thead>
            <tr>
                <th>Livre</th>
                <th>prix</th>
                <th>qte</th>
            </tr>";
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
            $text.="<tr>
                
            <td>".$livre->getTitre()."</td>
            <td>.$prix.</td>
            <td>".$qte."</td>
        </tr>";  
            
            


        }
        $text .= "<tfoot><tr><td colspan=''>Total</td><td>".$total." Dt</td></tr>";
        $commande->setTotal($total);
        $em->persist($commande);
        $em->flush();
        //Email
        //$session->remove('panier');
        //dd($this->getUser()->getUserIdentifier());
        $email = (new Email())
            ->from('ademsansa7@gmail.com')
            ->to($this->getUser()->getUserIdentifier())
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Commande Chez Symbooks')
            ->text('Sending emails is fun again!')
            ->html('<p>Votre commande est enregistré voice les details : </p>
            <table class="table">
        <tbody>
            <tr>
                <th>Id</th>
                <td>'.$commande->getId() .'</td>
            </tr>
            <tr>
                <th>Passé a : </th>
                <td>'.$commande->getCreatedAt()->format("Y-m-d H:i:s").'</td>
            </tr>
        </tbody>
    </table>' . $text);
        $mailer->send($email);
        $this->addFlash('message', 'Commande crée avec succès');
        return $this->redirectToRoute('checkout');
        }
   }