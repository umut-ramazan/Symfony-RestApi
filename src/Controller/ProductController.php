<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    private ProductRepository $productRepository;
    public  function __construct(ProductRepository  $productRepository)
    {
        $this->productRepository = $productRepository;
    }





    #[Route('/api/product',name: 'productSave', methods:['POST'])]

    #[OA\Response(
        response: 200,
        description: 'Declare And ID',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: Product::class, groups: ['full']))
        )
    )]
    #[OA\Parameter(
        name: 'order',
        in: 'query',
        description: 'The field used to order rewards',
        schema: new OA\Schema(type: 'string')
    )]

    #[OA\Tag(name: 'rewards')]
    #[Security(name: 'Bearer')]


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
}
