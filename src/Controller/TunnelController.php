<?php

namespace App\Controller;

use App\domain\Brand\Repository\BrandRepository;
use App\domain\Order\Entity\Order;
use App\domain\Order\Entity\OrderItem;
use App\domain\Order\Manager\OrderFactory;
use App\domain\Order\Normalizer\OrderNormalizer;
use App\domain\Product\Entity\Product;
use App\domain\Product\Repository\ProductRepository;
use App\domain\Promotion\Manager\PromotionResolver;
use App\domain\Shipping\Manager\ShippingVoter;
use App\domain\Tax\Manager\TaxResolver;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\VarDumper\VarDumper;

/**
 * @Route("/basket")
 */
class TunnelController extends AbstractController
{
    private BrandRepository $brandRepository;

    private ProductRepository $productRepository;

    private OrderFactory $orderFactory;

    private PromotionResolver $promotionResolver;

    private OrderNormalizer $orderNormalizer;

    private ShippingVoter $shippingVoter;

    private TaxResolver $taxResolver;

    private RequestStack $requestStack;

    public function __construct(
        BrandRepository $brandRepository,
        ProductRepository $productRepository,
        OrderFactory $orderFactory,
        PromotionResolver $promotionResolver,
        OrderNormalizer $orderNormalizer,
        ShippingVoter $shippingVoter,
        TaxResolver $taxResolver,
        RequestStack $requestStack
    ) {
        $this->brandRepository = $brandRepository;
        $this->productRepository = $productRepository;
        $this->orderFactory = $orderFactory;
        $this->promotionResolver = $promotionResolver;
        $this->orderNormalizer = $orderNormalizer;
        $this->shippingVoter = $shippingVoter;
        $this->taxResolver = $taxResolver;
        $this->requestStack = $requestStack;
    }

    public function cleanBasket(): void
    {
        $session = $this->requestStack->getCurrentRequest()->getSession();
        /** @var Order|null $order */
        $order = $session->get('order');

        if (null !== $order) {
            // @TODO Clean in BDD
            $session->set('order', null);
        }
    }


    /**
     * @Route("/basket/add", name="www_basket", methods="POST")
     * @Template("www/tunnel/basket.html.twig")
     * En code réel on récupérera une Request et on enregistrera l'order dans une session
     */
    public function addItemToBasket(Product $product, int $quantity): Order
    {
        $session = $this->requestStack->getCurrentRequest()->getSession();
        /** @var Order|null $order */
        $order = $session->get('order');

        if (null === $order) {
            $order = $this->orderFactory->create();
            $session->set('order', $order);
        }

        $order = $this->orderFactory->addProduct($order, $product, $quantity);

        $session->set('order', $order);

        return $order;
    }

    /**
     * @Route("/", name="www_basket")
     * @Template("www/tunnel/basket.html.twig")
     */
    public function basket(): array
    {
        $session = $this->requestStack->getCurrentRequest()->getSession();
        /** @var Order|null $order */
        $order = $session->get('order');

        $order = $this->promotionResolver->applyPromotionToOrder($order);

        $shippingHT = $this->shippingVoter->getTotalShippingByOrder($order);
        $shippingTTC = $this->taxResolver->calculatePriceTTC($shippingHT);

        $order = $this->orderNormalizer->normalize($order);
        return [
            'order' => $order,
            'shipping' =>  [
                'totalHT' => $shippingHT,
                'totalTTC' => $shippingTTC,
                'TVA' => $shippingTTC - $shippingHT,
            ]
        ];
    }

    /**
     * @Route("/basket/init", name="www_init_basket")
     */
    // @OnlyForTest Permet seulement d'initialiser le basket avec de faux produit pour le test
    public function initBasket(): RedirectResponse
    {
        $this->cleanBasket();

        $quantity1 = rand(1,5);
        $quantity2 = rand(1,5);
        $quantity3 = rand(1,5);

        $product1 = $this->productRepository->find(1);
        $product2 = $this->productRepository->find(2);
        $product3 = $this->productRepository->find(3);
        $this->addItemToBasket($product1, $quantity1);
        $this->addItemToBasket($product2, $quantity2);
        $this->addItemToBasket($product3, $quantity3);

        return $this->redirectToRoute('www_basket');
    }
}
