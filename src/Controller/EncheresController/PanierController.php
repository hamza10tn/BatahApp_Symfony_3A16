<?php

namespace App\Controller\EncheresController;

use App\Repository\ArticleRepository;
use App\Repository\EncheresRepository\BasketRepository;
use App\Repository\EncheresRepository\ProduitsRepository;
use App\Repository\EncheresRepository\UtilisateurRepository;
use App\Service\BasketService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    #[Route('/panier', name: 'app_panier')]
    public function index(BasketService $basketService, UtilisateurRepository $userRep, Request $request): Response
    {
        $session =  $request->getSession();
        $connectedUser = $session->get('user');
        if ($connectedUser == null) {
            return $this->redirectToRoute("app_login");
        }
        $basketData = $basketService->getCartItems($connectedUser->getIdUser());
        $basketItemsCount = count($basketData);

        $totalPrice = array_reduce($basketData, function ($total, $product) {
            return $total + $product->getIdArticle()->getArtprix();
        }, 0);

        return $this->render('panier/panier.html.twig', [
            'controller_name' => 'PanierController',
            'basketData' => $basketData,
            'totalPrice' => $totalPrice,
            'connectedUser' => $connectedUser,
            'basketItemsCount' => $basketItemsCount,
        ]);
    }


    #[Route('/addToBasket/{idArticle}', name: 'app_addToBasket')]
    public function addToBasket(Request $request, $idArticle, BasketService $basketService, UtilisateurRepository $userRep, ProduitsRepository $articleRep): Response
    {
        $session =  $request->getSession();
        $connectedUser = $session->get('user');
        $connectedUser = $userRep->find($connectedUser->getIdUser());

        $basketService->addToCart($connectedUser->getId(), $idArticle, $userRep, $articleRep);

        // add flash message
        $this->addFlash('command_ajoute', 'Article ajouté au panier');

        return $this->redirectToRoute('display_prod_front');
    }

    #[Route('/removeFromBasket/{idArticle}', name: 'app_removeFromBasket')]
    public function removeFromBasket($idArticle, BasketService $basketService, BasketRepository $basketRep): Response
    {
        $basketService->removeFromCart($idArticle, $basketRep);
        return $this->redirectToRoute('app_panier');
    }
}
