<?php
namespace App\Models;
use CodeIgniter\Model;
class TipoTrabajadorModel extends Model{
    protected $table = 'tipo_trabajador';
    protected $primaryKey = 'titra_id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'titra_rol',
        'titra_descripcion',
        'titra_estado'
    ];

}