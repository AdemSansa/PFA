<?php

namespace App\Controller;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Repository\CategoriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Faker\Factory;
class CategorieController extends AbstractController
{
    #[Route('admin/categorie', name: 'admin_categorie')]
    public function index(CategoriesRepository $rep): Response
    {
        $categories = $rep->findAll();
        return $this->render('categorie/index.html.twig', [
            'categories' => $categories,
        ]);
    }
}
