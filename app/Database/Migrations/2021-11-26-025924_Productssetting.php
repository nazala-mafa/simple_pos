<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ProductsSetting extends Migration
{
    public function up()
    {
        /**
         * Products Item
         */
		$this->forge->addField([
			'id' => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'auto_increment' => true
			],
            'user_id' => [
                'type'          => 'INT',
                'constraint'    => 11,
                'unsigned'      => true,
            ],
			'name' => [
				'type'           => 'VARCHAR',
				'constraint'     => 255,
			],
            'quantity' => [
                'type'          => 'INT',
                'constraint'    => 11,
                'default'       => 0
            ],
            'sold' => [
                'type'          => 'INT',
                'constraint'    => 11,
                'default'       => 0
            ],
            'buy_price' => [
                'type'          => 'INT',
                'constraint'    => 11,
                'unsigned'      => true
            ],
            'sell_price' => [
                'type'          => 'INT',
                'constraint'    => 11,
                'unsigned'      => true
            ],
            'status' => [
                'type'          => 'VARCHAR',
                'constraint'    => 255
            ],
            'image' => [
                'type'          => 'VARCHAR',
                'constraint'    => 255,
                'null'          => true
            ],
			'created_at timestamp default current_timestamp',
            'updated_at timestamp default current_timestamp on update current_timestamp',
            'deleted_at' => [
                'type' => 'timestamp',
                'null' => true
            ],
		]);
		$this->forge->addKey('id', TRUE);
        $this->forge->addForeignKey('user_id', 'users', 'id', '', 'CASCADE');
		$this->forge->createTable('products_item', TRUE);

        /**
         * Products Category
         */
        $this->forge->addField([
            'id' => [
                'type'          => 'INT',
                'constraint'    => 11,
                'unsigned'      => true,
                'auto_increment'=> true,
            ],
            'user_id' => [
                'type'          => 'INT',
                'constraint'    => 11,
                'unsigned'      => true
            ],
            'name' => [
                'type'          => 'VARCHAR',
                'constraint'    => 255
            ],
            'created_at timestamp default current_timestamp',
            'updated_at timestamp default current_timestamp on update current_timestamp',
            'deleted_at' => [
                'type'          => 'timestamp',
                'null'          => true
            ]
        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->addForeignKey('user_id', 'users', 'id', '', 'CASCADE');
        $this->forge->createTable('products_category', true);

        /** 
         * Products Item Category
         */
        $this->forge->addField([
            'product_item_id' => [
                'type'          => 'INT',
                'constraint'    => 11,
                'unsigned'      => true,
            ],
            'product_category_id' => [
                'type'          => 'INT',
                'constraint'    => 11,
                'unsigned'      => true,
            ]
        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->addForeignKey('product_item_id', 'products_item', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('product_category_id', 'products_category', 'id', '', 'CASCADE');
        $this->forge->createTable('products_item_category', true);
    }

    public function down()
    {
        $this->forge->dropTable('products_item');
        $this->forge->dropTable('products_category');
        $this->forge->dropTable('products_item_category');
    }
}
