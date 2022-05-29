<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Products extends Seeder
{
    public function run()
    {
        $products = [
            [
                'user_id'   => 1,
                'name'      => "Camper Mug",
                'status'    => 'draft',
                'image'     => "Camper Mug.jpg",
            ],
            [
                'user_id'   => 1,
                'name'      => "Contrast Coffee Mug",
                'status'    => 'draft',
                'image'     => "Contrast Coffee Mug.jpg",
            ],
            [
                'user_id'   => 1,
                'name'      => "Fitted Cotton, Poly T-Shirt by Next Level",
                'status'    => 'draft',
                'image'     => "Fitted Cotton, Poly T-Shirt by Next Level.jpg",
            ],
            [
                'user_id'   => 1,
                'name'      => "Full Color Mug",
                'status'    => 'draft',
                'image'     => "Full Color Mug.jpg",
            ],
            [
                'user_id'   => 1,
                'name'      => "Hanes Adult T-Shirt",
                'status'    => 'draft',
                'image'     => "Hanes Adult T-Shirt.jpg",
            ],
            [
                'user_id'   => 1,
                'name'      => "iPhone 6,6s Plus Rubber Case",
                'status'    => 'draft',
                'image'     => "iPhone 6,6s Plus Rubber Case.jpg",
            ],
            [
                'user_id'   => 1,
                'name'      => "iPhone 6,6s Rubber Case",
                'status'    => 'draft',
                'image'     => "iPhone 6,6s Rubber Case.jpg",
            ],
            [
                'user_id'   => 1,
                'name'      => "iPhone 7 Plus, 8 Plus Rubber Case",
                'status'    => 'draft',
                'image'     => "iPhone 7 Plus, 8 Plus Rubber Case.jpg",
            ],
            [
                'user_id'   => 1,
                'name'      => "iPhone 7, 8 Case",
                'status'    => 'draft',
                'image'     => "iPhone 7, 8 Case.jpg",
            ],
            [
                'user_id'   => 1,
                'name'      => "iPhone X, XS Case",
                'status'    => 'draft',
                'image'     => "iPhone X, XS Case.jpg",
            ],
            [
                'user_id'   => 1,
                'name'      => "Men's Premium Organic T-Shirt",
                'status'    => 'draft',
                'image'     => "Men's Premium Organic T-Shirt.jpg",
            ],
            [
                'user_id'   => 1,
                'name'      => "Men's Premium T-Shirt",
                'status'    => 'draft',
                'image'     => "Men's Premium T-Shirt.jpg",
            ],
            [
                'user_id'   => 1,
                'name'      => "Men's T-Shirt",
                'status'    => 'draft',
                'image'     => "Men's T-Shirt.jpg",
            ],
            [
                'user_id'   => 1,
                'name'      => "Men's Zip Hoodie",
                'status'    => 'draft',
                'image'     => "Men's Zip Hoodie.jpg",
            ],
            [
                'user_id'   => 1,
                'name'      => "Panoramic Mug",
                'status'    => 'draft',
                'image'     => "Panoramic Mug.jpg",
            ],
            [
                'user_id'   => 1,
                'name'      => "Travel Mug with Handle",
                'status'    => 'draft',
                'image'     => "Travel Mug with Handle.jpg",
            ],
            [
                'user_id'   => 1,
                'name'      => "Unisex ComfortWash Garment Dyed T-Shirt",
                'status'    => 'draft',
                'image'     => "Unisex ComfortWash Garment Dyed T-Shirt.jpg",
            ],
            [
                'user_id'   => 1,
                'name'      => "Unisex Fleece Zip Hoodie",
                'status'    => 'draft',
                'image'     => "Unisex Fleece Zip Hoodie.jpg",
            ],
            [
                'user_id'   => 1,
                'name'      => "Unisex Oversize T-Shirt",
                'status'    => 'draft',
                'image'     => "Unisex Oversize T-Shirt.jpg",
            ]
        ];
        $this->db->table('products_item')->insertBatch($products);
    }
}
