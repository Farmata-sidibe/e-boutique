<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    #[Route('/panier', name: 'cart_index')]
    public function index(SessionInterface $session, ProductRepository $productRepository): Response
    {
        $panier = $session->get('panier', []);
        $panierWithData = [];

        foreach($panier as $id_product => $quantity){
            $panierWithData[] = [
                'product' => $productRepository->find($id_product),
                'quantity' => $quantity
            ];
        }
       
        return $this->render('panier/index.html.twig', [
          'items' =>$panierWithData
        ]);
    }

    #[Route('/panier/add/{id_product}', name: 'cart_add')]
    public function addCart($id_product, SessionInterface $session): Response
    {
        $panier = $session->get('panier', []) ;

        if(!empty($panier[$id_product])){
            $panier[$id_product]++;

        }else{
            $panier[$id_product] = 1;

        }


        $session->set('panier', $panier);

       

        return $this->redirectToRoute('cart_index');
    }

    #[Route('/panier/remove/{id_product}', name: 'cart_remove_product')]
    public function removeCartProduct($id_product, SessionInterface $session): Response
    {
        $panier = $session->get('panier', []) ;

        if(!empty($panier[$id_product])){
            unset($panier[$id_product]);

        }


        $session->set('panier', $panier);

       

        return $this->redirectToRoute('cart_index', []);
    }
   
}
