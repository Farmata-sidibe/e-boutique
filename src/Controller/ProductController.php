<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product;

class ProductController extends AbstractController
{
    #[Route('/', name: 'list_product')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();

        $products = $em->getRepository(Product::class)->findAll();
        return $this->render('product/index.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/product/{id_product}', name: 'product_view')]
    public function viewProduct($id_product,ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $product = $em->getRepository(Product::class)->find($id_product);

        return $this->render('product/productView.html.twig', [
            'product' => $product,
        ]);
    }

}
