<?php

namespace App\TestProject\Actions\UpdatePrices;

use App\Models\Price;
use Illuminate\Support\Collection;

class UpdatePricesBuilder implements Interfaces\BuilderInterface
{

    private Collection $new_product_prices;
    private \Illuminate\Database\Eloquent\Collection $product_prices;
    private array $response;

    public function __construct(private string $product_guid)
    {
        $this->response = [];
    }

    public function setProductPrices(): void
    {
        $this->product_prices = Price::where('product_guid', $this->product_guid)->get();
    }

    public function setNewProductPricesCollection(array $new_product_prices): void
    {
        $this->new_product_prices = collect($new_product_prices);
    }

    public function updateCreatedProductPrices(): void
    {
        foreach ($this->product_prices as $price){

            $new_price = $this->new_product_prices->where('guid', $price->guid)->first();

            if(is_null($new_price)){
                $price->is_active = 0;

                if($price->save()){
                    $this->response[] = [
                        'guid' => $price->guid,
                        'status' => 'deactivated'
                    ];
                }

                continue;
            }

            $price->price = $new_price['price'];
            $price->is_active = 1;


            if($price->save()){
                $this->response[] = [
                    'guid' => $price->guid,
                    'status' => 'updated'
                ];
            }

            $this->new_product_prices = $this->new_product_prices
                ->filter(fn($item) => $item['guid'] !== $price->guid);

        }
    }

    public function createNewProductPrices(): void
    {
        $this->new_product_prices->each(function (array $item, int $key){

            $price = new Price();
            $price->guid = $item['guid'];
            $price->product_guid = $this->product_guid;
            $price->price = $item['price'];


            if($price->save()){
                $this->response[] = [
                    'guid' => $item['guid'],
                    'status' => 'created'
                ];
            }
        });
    }

    public function __get(string $name)
    {
        return $this->$name;
    }
}
