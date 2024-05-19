<?php

namespace App\Controller;
use App\Repository\LivreRepository;
use App\Repository\OrdersRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
#[IsGranted('ROLE_ADMIN')]
class DashbordadminController extends AbstractController
{
    #[Route('/dashbordadmin', name: 'app_dashbordadmin')]
    public function index(LivreRepository $l, OrdersRepository $or): Response
    {
        $tname =[];
        $tqte =[];
        $tmax=[];
        $t[]='nombre de commande';
      $res=$l->findBooksSoldQuantityBetweenDates(new \DateTime('2024-05-11'),new \DateTime('2024-05-15'));
      $resu=$or->commandestotal(new \DateTime('2024-05-11'),new \DateTime('2024-05-15'));
      //dd($resu);
      //dd($res);
      foreach ($res as $r) {
        $tname []  = $r['titre'];
        $tqte []=$r['total_quantity'];
       }
       foreach($resu as $r){
         $tmax[]=$r['total'];
       }
       
       
      /*foreach($tname as $t){
        echo $t;
      }*/
        return $this->render('dashbordadmin/index.html.twig', [
            'nom' => json_encode($tname),
            'qte' => json_encode($tqte),
            'max' => json_encode($tmax),
            'com'=>json_encode($t),
        ]);
    }
}
