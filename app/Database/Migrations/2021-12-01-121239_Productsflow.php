<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ProductsFlow extends Migration
{
    public function up()
    {
        /**
         * Customers
         */
        $this->forge->addField([
            'id' => [
                'type'              => 'INT',
                'constraint'        => '11',
                'unsigned'          => true,
                'auto_increment'    => true
            ],
            'user_id' => [
                'type'              => 'INT',
                'constraint'        => '11',
                'unsigned'          => true,
            ],
            'name' => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
            ],
            'password' => [
                'type'              => 'VARCHAR',
                'constraint'        => 255
            ],
            'phone' => [
                'type'              => 'VARCHAR',
                'constraint'        => 20,
            ],
            'address' => [
                'type'              => 'TEXT',
            ],
            'avatar' => [
                'type'              => 'VARCHAR',
                'constraint'        => 100,
                'null'              => true
            ],
            'status' => [
                'type'              => 'VARCHAR',
                'constraint'        => 50,
                'null'              => true
            ],
            'created_at timestamp default current_timestamp',
            'updated_at timestamp default current_timestamp on update current_timestamp',
            'deleted_at' => [
                'type' => 'timestamp',
                'null' => true
            ],
        ]);
		$this->forge->addKey('id', TRUE);
		$this->forge->createTable('customers', TRUE);

        /**
         * Products Orders
         */
        $this->forge->addField([
            'id' => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
                'auto_increment'    => true
            ],
            'user_id' => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true
            ],
            'customer_id' => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true
            ],
            'status' => [
                'type'              => 'VARCHAR',
                'constraint'        => 50,
            ],
            'amount' => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true
            ],
            'paid' => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true
            ],
            'note' => [
                'type'              => 'TEXT',
                'null'              => true
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
        $this->forge->addForeignKey('customer_id', 'customers', 'id', '', 'CASCADE');
		$this->forge->createTable('orders', TRUE);

        /**
         * Products Orders Detail
         */
        $this->forge->addField([
            'id' => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
                'auto_increment'    => true
            ],
            'order_id' => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true
            ],
            'product_id' => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true
            ],
            'quantity' => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true
            ],
            'price_unit' => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true
            ],
            'note' => [
                'type'              => 'TEXT',
                'null'              => true
            ],
            'created_at timestamp default current_timestamp',
            'updated_at timestamp default current_timestamp on update current_timestamp',
            'deleted_at' => [
                'type' => 'timestamp',
                'null' => true
            ],
        ]);
		$this->forge->addKey('id', TRUE);
        $this->forge->addForeignKey('order_id', 'orders', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('product_id', 'products_item', 'id', '', 'CASCADE');
		$this->forge->createTable('order_detail', TRUE);

        /** 
         * Supplier
         */
        $this->forge->addField([
            'id' => [ 'type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'unsigned' => true ],
            'user_id' => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true ],
            'name' => [ 'type' => 'VARCHAR', 'constraint' => 255 ],
            'phone' => [ 'type' => 'VARCHAR', 'constraint' => 20 ],
            'address' => [ 'type' => 'TEXT' ],
            'status' => [ 'type' => 'VARCHAR', 'constraint' => 50 ],
            'created_at timestamp default current_timestamp',
            'updated_at timestamp default current_timestamp on update current_timestamp',
            'deleted_at' => [
                'type' => 'timestamp',
                'null' => true
            ],
        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->addForeignKey('user_id', 'users', 'id', '', 'CASCADE');
        $this->forge->createTable('suppliers');

        /**
         * Products Supplies
         */
        $this->forge->addField([
            'id' => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
                'auto_increment'    => true
            ],
            'user_id' => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true
            ],
            'supplier_id' => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true
            ],
            'amount' => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true
            ],
            'paid' => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true
            ],
            'status' => [
                'type'              => 'VARCHAR',
                'constraint'        => 50,
                'null'              => true
            ],
            'note' => [
                'type'              => 'TEXT',
                'null'              => true
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
        $this->forge->addForeignKey('supplier_id', 'suppliers', 'id', '', 'CASCADE');
		$this->forge->createTable('supplies', TRUE);

        /**
         * Products Supply Detail
         */
        $this->forge->addField([
            'id' => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
                'auto_increment'    => true
            ],
            'supplies_id' => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true
            ],
            'product_id' => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true
            ],
            'quantity' => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true
            ],
            'buy_price_unit' => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true
            ],
            'sell_price_unit' => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true
            ],
            'note' => [
                'type'              => 'TEXT',
                'null'              => true
            ],
            'created_at timestamp default current_timestamp',
            'updated_at timestamp default current_timestamp on update current_timestamp',
            'deleted_at' => [
                'type' => 'timestamp',
                'null' => true
            ],
        ]);
		$this->forge->addKey('id', TRUE);
        $this->forge->addForeignKey('supplies_id', 'supplies', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('product_id', 'products_item', 'id', '', 'CASCADE');
		$this->forge->createTable('supply_detail', TRUE);

        
    }

    public function down()
    {
        $this->forge->dropTable('customers');
        $this->forge->dropTable('orders');
        $this->forge->dropTable('order_detail');
        $this->forge->dropTable('suppliers');
        $this->forge->dropTable('supplies');
        $this->forge->dropTable('supply_detail');
    }
}
