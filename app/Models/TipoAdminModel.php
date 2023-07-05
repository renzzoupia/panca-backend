<?php
namespace App\Models;
use CodeIgniter\Model;
class TipoAdminModel extends Model{
    protected $table = 'tipo_admin';
    protected $primaryKey = 'tiad_id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'tiad_nombre',
        'tiad_descrip',
        'tiad_estado'
    ];

}