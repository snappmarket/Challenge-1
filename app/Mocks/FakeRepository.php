<?php


namespace App\Mocks;


class FakeRepository
{
    /**
     * @var Product
     */
    private $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function getProductById(int $id)
    {
        $products = $this->product->query()->get();
        if (!array_key_exists($id, $products)) {
            throw new EntityNotFoundException("Object with id {$id} does not exist.");
        }

        return $products->find($id);
    }
}
