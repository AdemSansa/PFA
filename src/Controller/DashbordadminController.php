<?php

namespace App\Controller;
use App\Repository\LivreRepository;
use App\Repository\OrdersRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
#[IsGranted('ROLE_ADMIN')]
class DashbordadminController extends AbstractController
{
    #[Route('/dashbordadmin', name: 'app_dashbordadmin')]
    public function index(LivreRepository $l, OrdersRepository $or,Request $request): Response
    {
      //dd($request->isXmlHttpRequest());
      $dateFrom=new \DateTime('2024-05-11');
      $dateTo=new \DateTime('2024-05-15');
      if ( $request->isMethod('POST')) {
        $formData = $request->request->all(); // Get form data from POST request

        // Validate and process form data (e.g., retrieve dates, perform calculations)
        $dateTime1 = $formData['date1'];
        $dateTime2 = $formData['date2'];
        $dateFrom = new \DateTime($dateTime1);
        $dateTo = new \DateTime($dateTime2);
        if(empty($dateFrom) && empty($dateTo)){
          $dateFrom=new \DateTime('2024-05-11');
          $dateTo=new \DateTime('2024-05-15');
        }
      
      }
        $tname =[];
        $tqte =[];
        $tmax=[];
        $t[]='nombre de commande';
      $res=$l->findBooksSoldQuantityBetweenDates($dateFrom,$dateTo);
      $resu=$or->commandestotal($dateFrom,$dateTo);
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
