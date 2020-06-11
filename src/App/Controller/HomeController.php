<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route(path="/robots.txt", methods={"get"})
     * @return Response
     */
    public function robots(): Response
    {
        return new Response(
            <<<TXT
            User-agent: *
            Disallow: /
            TXT,
            Response::HTTP_OK,
            ['Content-Type' => 'text/plain']
        );
    }
}
