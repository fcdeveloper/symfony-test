<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Product;

class SalesController extends AbstractController
{
    /**
     * @Route("/sales", name="sales")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Product::class);
        $products = $repo->findAll();
        return $this->render('sales/index.html.twig', [
            'controller_name' => 'SalesController',
            'products' => $products
        ]);
    }

    /**
     * @Route("/new", name="new")
     */
    public function new()
    {
        return $this->render('sales/new.html.twig', [
            'controller_name' => 'SalesController',
        ]);
    }
}
