<?php

namespace App\TestProject\Actions\UpdatePrices\Interfaces;

interface DirectorInterface
{
    public function build(BuilderInterface $builder): array;
}
