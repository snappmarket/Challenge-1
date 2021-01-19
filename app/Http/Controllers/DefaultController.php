<?php


namespace App\Http\Controllers;


use App\Mocks\FakeRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class DefaultController
{
    /**
     * @var FakeRepository
     */
    private $repo;

    public function __construct(FakeRepository $fakeRepository)
    {
        $this->repo = $fakeRepository;
    }

    public function index(Request $request)
    {
        $productName = $request->query->get('name');
        $quantity = $request->query->get('quantity');
        $price = $request->query->get('price');
        $type = $request->query->get('type');

        $success = true;
        try {
            if ($type == 'normal') {
                Log::debug('Product is of type: normal');

                $firstUnderscore = strpos($productName, '_');
                $secondUnderscore = strpos($productName, '_', $firstUnderscore + 1);
                $id = (int) substr($productName, $firstUnderscore + 1, $secondUnderscore - $firstUnderscore - 1);

                $product = $this->repo->getProductById($id);
                $product->quantity = $quantity;
                $product->price = $price;
                $product->save();

                $success = true;
            } elseif ($type == 'refrigerator') {
                Log::debug('Product is of type: refrigerator');

                $firstUnderscore = strpos($productName, '_');
                $secondUnderscore = strpos($productName, '_', $firstUnderscore + 1);
                $id = (int) substr($productName, $firstUnderscore + 1, $secondUnderscore - $firstUnderscore - 1);

                $product = $this->repo->getProductById($id);
                $product->quantity = $quantity;
                $product->price = $price;
                $product->isRefrigirator = true;
                $product->save();

                $success = true;
            }
        } catch (\Exception $exception) {
            $success = false;
        }

        if ($success) {
            return new Response(['status' => 'ok'], 200);
        }

        return new Response(['status' => 'error', 500]);
    }
}
