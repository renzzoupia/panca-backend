<?php
namespace App\Models;
use CodeIgniter\Model;
class TipoUsuarioModel extends Model{
    protected $table = 'tipo_usuario';
    protected $primaryKey = 'tius_id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'tius_descrip',
        'tius_estado'
    ];
}