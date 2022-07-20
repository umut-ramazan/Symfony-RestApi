<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use FOS\ElasticaBundle\Finder\PaginatedFinderInterface;
use Elastica\Util;



class ProductController extends AbstractController
{
    private ProductRepository $productRepository;
    private $finder;

    public  function __construct(ProductRepository  $productRepository,PaginatedFinderInterface $finder)
    {
        $this->productRepository = $productRepository;
        $this->finder=$finder;
    }

    #[Route('/product',name: 'productSave', methods:['POST'])]


    public function productSave(Request $request): JsonResponse
    {
        $request = $request->toArray();
        $product = new Product();

        $product
            ->setProductName($request["name"])
            ->setProductContent($request["content"])
            ->setPrice($request["price"])
        ;

        $this->productRepository->add($product,true);

        return new JsonResponse('Ok'.$product->getId());
    }


    #[Route('/product-remove', name: 'productRemove',methods:'POST')]
    public function productRemove(Request $request): JsonResponse
    {
        $request = $request->toArray();
        $product = $this->productRepository->find($request["productId"]);

        if($product){
            $this->productRepository->remove($product,true);
            return  new JsonResponse('Ürün Silindi Ok ');
        }
        return new JsonResponse('Ürün Bulunamadı! ');

    }

    #[Route('/product-update', name: 'productUpdate',methods:'POST')]
    public function productUpdate(Request $request): JsonResponse
    {
        $request = $request->toArray();

        $product = $this->productRepository->find($request["productId"]);

        if($product){

            $product
                ->setProductName($request["name"])
                ->setProductContent($request["content"])
                ->setPrice($request["price"])
            ;

            $this->productRepository->add($product,true);
            return  new JsonResponse('Ürün Güncellendi. Ürün Adı: '.$product->getProductName());
        }

        return new JsonResponse('Ürün Bulunamadı! ');

    }


    #[Route('/elastic')]
    public function denemeR(): JsonResponse
    {

        $product = $this->productRepository->findAll("elastic");
        dump($product);
        $result = $this->finder->find("");
        return new JsonResponse($result);

    }
}
