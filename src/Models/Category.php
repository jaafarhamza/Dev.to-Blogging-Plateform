<?php
namespace App\Models;
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Config\MethodORM;

class Category extends MethodORM {
    public function __construct() {
        parent::__construct('categories');
    }
}
