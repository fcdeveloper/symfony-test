<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Product;
use App\Entity\Sales;

class SalesController extends AbstractController
{
    /**
     * @Route("/sales/{product?}", name="sales")
     */
    public function index($product = null)
    {
        $em = $this->getDoctrine()->getManager();
        //get products
        $product_repo = $em->getRepository(Product::class);
        $products = $product_repo->findAll();
        //get sales
        $sales_repo = $em->getRepository(Sales::class);
        $sales = null;
        if ($product !== null) {
            //get product
            $_product = $product_repo->find($product);
            if ($_product) {
                $sales = $sales_repo
                    ->findBy(['product' => $_product->getProductname()]);
            }
        } else {
            $sales = $sales_repo->findAll();
        }
        return $this->render('sales/index.html.twig', [
            'controller_name' => 'SalesController',
            'product_id' => $product,
            'products' => $products,
            'sales' => $sales
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
