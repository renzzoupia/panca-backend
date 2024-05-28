<?php
namespace App\Models;
use CodeIgniter\Model;
class TipoProductoModel extends Model{
    protected $table = 'tipo_producto';
    protected $primaryKey = 'tipr_id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'tipr_nombre',
        'tipr_estado'
    ];
}