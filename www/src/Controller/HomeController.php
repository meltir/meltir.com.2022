<?php

namespace App\Controller;

use App\Entity\PagePost;
use App\Entity\YtCategories;
use App\Entity\YtChannels;
use App\Entity\YtVideos;
use App\Repository\PagePostRepository;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home', methods: ['GET'])]
    public function index(ManagerRegistry $doctrine): Response
    {
        $posts = $doctrine->getRepository(PagePost::class)->findForThisPage('home');
        return $this->render('home.html.twig',['posts'=>$posts]);
    }

    #[Route('/gallery', name: 'app_gallery', methods: ['GET'])]
    public function gallery(ManagerRegistry $doctrine): Response {
        $posts = $doctrine->getRepository(PagePost::class)->findForThisPage('gallery');
        return $this->render('gallery.html.twig',['galleries'=>$posts]);
    }

    #[Route('/cv', name: 'app_cv', methods: ['GET'])]
    public function cv(ManagerRegistry $doctrine): Response {
        $posts = $doctrine->getRepository(PagePost::class)->findForThisPage('cv');
        return $this->render('cv.html.twig',['posts'=>$posts]);
    }

    #[Route('/youtube/{slug?dev}/{page?1}', name: 'app_youtube', methods: ['GET'])]
    public function youtube( YtCategories $category, ManagerRegistry $doctrine, int $page): Response {
        $per_page = 10;
        $categories = $doctrine
            ->getRepository(YtCategories::class)
            ->getActiveCategories();

        $channel_repo = $doctrine->getRepository(YtChannels::class);
        $channels = $channel_repo->getChannelPage($page, $per_page, $category);
        $pages = $channel_repo->countPages($per_page,$category);

        $videos_repo = $doctrine->getRepository(YtVideos::class);
        $videos = [];

        foreach ($channels as $channel) {
            $videos[$channel->getId()] = $videos_repo->getLatestVideosQuery($channel,4,1)->getResult();
        }
        return $this->render('youtube.html.twig',[
            'paginator'=>[
                'page'=>$page,
                'pages'=>$pages,
                'base_route'=>'app_youtube'
            ],
            'channels'=>$channels,
            'categories'=>$categories,
            'current_category'=>$category,
            'videos'=>$videos
        ]);
    }
}
