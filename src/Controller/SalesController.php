<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

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
     * @Route("/new/{product?}", name="new")
     */
    public function new($product = null)
    {
        $em = $this->getDoctrine()->getManager();
        //get products
        $product_repo = $em->getRepository(Product::class);
        $products = $product_repo->findAll();

        return $this->render('sales/new.html.twig', [
            'controller_name' => 'SalesController',
            'product_id' => $product,
            'products' => $products
        ]);
    }

    /**
     * @Route("/new_sale", name="new_sale")
     */
    public function new_sale(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $product_repo = $em->getRepository(Product::class);

        $product = $request->request->get('product');
        $amount = $request->request->get('amount');
        if ($amount > 0.01 && $amount <= 100) {
            if ($product > 0) {
                $sale = new Sales();
                //get product
                $_product = $product_repo->find($product);
                //save new sale
                $sale->setDate(new \DateTime("now"));
                $sale->setProduct($_product->getProductName());
                $sale->setAmount($amount);
                //save changes
                $em->persist($sale);
                $em->flush();
            }
            return $this->redirect($this->generateUrl('sales') . '/' . $product);
        } else {
            $this->get('session')->getFlashBag()->add('error', 'The amount must be > 0.01 and <= 100!');
            return $this->redirect($this->generateUrl('new') . '/' . $product);
        }
    }
}
