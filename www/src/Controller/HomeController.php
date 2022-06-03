<?php

namespace App\Controller;

use App\Entity\PagePost;
use App\Repository\PagePostRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $posts = $doctrine->getRepository(PagePost::class)->findForThisPage('home');
        return $this->render('home.html.twig',['posts'=>$posts]);
    }

    #[Route('/gallery', name: 'app_gallery')]
    public function gallery(ManagerRegistry $doctrine): Response {
        $posts = $doctrine->getRepository(PagePost::class)->findForThisPage('gallery');
        return $this->render('gallery.html.twig',['galleries'=>$posts]);
    }

    #[Route('/cv', name: 'app_cv')]
    public function cv(ManagerRegistry $doctrine): Response {
        $posts = $doctrine->getRepository(PagePost::class)->findForThisPage('cv');
        return $this->render('cv.html.twig',['posts'=>$posts]);
    }



}
