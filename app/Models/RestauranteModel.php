<?php
namespace App\Models;
use CodeIgniter\Model;
class RestauranteModel extends Model{
    protected $table = 'restaurante';
    protected $primaryKey = 'rest_id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'rest_usua_id',
        'rest_razon_social',
        'rest_ruc',
        'rest_descrip',
        'rest_direccion',
        'rest_telefono',
        'rest_horario',
        'rest_estado',
    ];

    public function getRestaurante(){
        return $this -> db -> table('restaurante r')
        -> where('r.rest_estado', 1)
        -> join('usuario u', 'u.usua_id = r.rest_usua_id')
        -> get() -> getResultArray();
    }

    public function getId($id){
        return $this -> db -> table('restaurante r')
        -> where('r.rest_id', $id)
        -> where('r.rest_estado', 1)
        -> join('usuario u', 'u.usua_id = r.rest_usua_id')
        -> get() -> getResultArray();
    }
    public function getUsuario(){
        return $this -> db -> table('usuario u')
        -> where('u.usua_estado', 1)
        -> get() -> getResultArray();
    }
}