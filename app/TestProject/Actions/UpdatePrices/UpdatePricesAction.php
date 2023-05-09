<?php

namespace App\TestProject\Actions\UpdatePrices;

class UpdatePricesAction
{
    public static function run(string $product_guid, array $new_prices): array
    {
        $builder = new UpdatePricesBuilder($product_guid);
        $director = new UpdatePricesDirector($new_prices);
        return $director->build($builder);
    }
}
