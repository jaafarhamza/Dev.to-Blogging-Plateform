<?php
namespace App\Models;
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Config\MethodORM;

class Tag extends MethodORM {
    public function __construct() {
        parent::__construct('tags');
    }
}
