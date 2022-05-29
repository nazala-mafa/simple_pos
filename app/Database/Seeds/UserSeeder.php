<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $password = \Myth\Auth\Password::hash('1234');
        $this->db->query("ALTER TABLE `users` ADD `img_uri` VARCHAR(50) NULL DEFAULT NULL AFTER `force_pass_reset`;");
        $this->db->query("INSERT INTO `users` (`id`, `email`, `username`, `password_hash`, `active`, `img_uri`) VALUES
        (1, 'admin@gmail.com', 'admin', '$password', 1, NULL),
        (2, 'owner@gmail.com', 'owner', '$password', 1, NULL),
        (3, 'casier@gmail.com', 'casier', '$password', 1, NULL);");      
        
        //tambah role
        $this->db->query("INSERT INTO `auth_groups` (`id`, `name`, `description`) VALUES 
            ('1', 'admin', 'admin umum'), 
            ('2', 'owner', 'pemilik'),
            ('3', 'casier', 'kasir')
        ;");

        //tambah admin
        $this->db->query("INSERT INTO `auth_groups_users` (`group_id`, `user_id`) VALUES 
            ('1', '1'),
            ('2', '2'),
            ('3', '3')
        ;");
    }
}
