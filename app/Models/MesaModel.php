<?php
namespace App\Models;
use CodeIgniter\Model;
class MesaModel extends Model{
    protected $table = 'mesa';
    protected $primaryKey = 'mesa_id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'mesa_rest_id',
        'mesa_numero',
        'mesa_cantidad_personas',
        'mesa_referencia_ubicacion',
        'mesa_activo',
        'mesa_estado'
    ];

    public function getMesa(){
        return $this -> db -> table('mesa m')
        -> where('m.mesa_estado', 1)
        -> join('restaurante r', 'r.rest_id = m.mesa_rest_id')
        -> get() -> getResultArray();
    }

    public function getId($id){
        return $this -> db -> table('mesa m')
        -> where('m.mesa_id', $id)
        -> where('m.mesa_estado', 1)
        -> join('restaurante r', 'r.rest_id = m.mesa_rest_id')
        -> get() -> getResultArray();
    }
    public function getRestaurante(){
        return $this -> db -> table('restaurante r')
        -> where('r.rest_estado', 1)
        -> get() -> getResultArray();
    }
}