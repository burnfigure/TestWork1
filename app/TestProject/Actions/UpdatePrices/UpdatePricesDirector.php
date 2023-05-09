<?php

namespace App\TestProject\Actions\UpdatePrices;

use App\TestProject\Actions\UpdatePrices\Interfaces\BuilderInterface;

class UpdatePricesDirector implements Interfaces\DirectorInterface
{

    public function __construct(private array $new_prices){}

    public function build(BuilderInterface $builder): array
    {

        $builder->setNewProductPricesCollection($this->new_prices);
        $builder->setProductPrices();
        $builder->updateCreatedProductPrices();
        $builder->createNewProductPrices();
        return $builder->response;
    }
}
