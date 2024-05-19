<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Repository\OrdersRepository;
use Doctrine\Common\Collections\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserSettingsController extends AbstractController
{
    #[Route('/profile/settings', name: 'app_profile_settings')]
    public function index(): Response
    {
        return $this->render('user_settings/index.html.twig', [
            'controller_name' => 'UserSettingsController',
        ]);
    }
    #[Route('/profile/show', name: 'app_profile_show')]
    public function show(): Response
    {
        $user = $this->getUser();
       
        return $this->render('user_settings/show.html.twig', [
            'user' => $user,
        ]);
    }
    #[Route('/profile/orders', name: 'app_profile_orders')]
    public function orders(OrdersRepository $ord): Response
    {
        $user = $this->getUser();
     
        $allorders = $ord->findByUsers(
            ['users_id' => '32']
            );
        //dd($allorders);
        return $this->render('user_settings/orders.html.twig', [
            'orders' => $allorders,
        ]);
    }
    


}
