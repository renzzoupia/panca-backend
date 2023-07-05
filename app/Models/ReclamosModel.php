<?php
namespace App\Models;
use CodeIgniter\Model;
class ReclamosModel extends Model{
    protected $table = 'reclamos';
    protected $primaryKey = 'recl_id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'recl_tipo_reclamo',
        'recl_descrip',
        'recl_estado'
    ];
}