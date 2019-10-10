<?php

namespace Webkul\Custom\Helpers;

use Webkul\Custom\Helpers\GenerateProduct;

class ProductSeeder
{
    protected $generateProduct;

    public function __construct(GenerateProduct $generateProduct)
    {
        $this->generateProduct = $generateProduct;
    }

    public function handle($id)
    {
        try {
            $result = $this->generateProduct->create();
        } catch (\Exception $e) {
        }
    }
}