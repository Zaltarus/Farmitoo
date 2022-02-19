<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Promotion;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController
{
    /**
     * @Route("/", name="www_home")
     * @Template("www/index.html.twig")
     */
    public function index(): array
    {
        return [];
    }
}
