<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class EmptyProducts extends Seeder
{
  public function run()
  {
    $this->db->query(" DELETE FROM `study_pos`.`products_item` ");
  }
}
