<?php
namespace App\Models;
use CodeIgniter\Model;
class TipoComidaModel extends Model{
    protected $table = 'tipo_comida';
    protected $primaryKey = 'tico_id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'tico_nombre',
        'tico_estado'
    ];

}