<?php
namespace App\Models;
use CodeIgniter\Model;
class ClienteModel extends Model{
    protected $table = 'cliente';
    protected $primaryKey = 'clie_id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'clie_usua_id',
        'clie_nombres',
        'clie_apellidos',
        'clie_dni',
        'clie_celular',
        'clie_correo',
        'clie_foto',
        'clie_direccion',
        'clie_estado'
    ];

    public function getCliente(){
        return $this -> db -> table('cliente c')
        -> where('c.clie_estado', 1)
        -> join('usuario u', 'u.usua_id = c.clie_usua_id')
        -> get() -> getResultArray();
    }

    public function getId($id){
        return $this -> db -> table('cliente c')
        -> where('c.clie_id', $id)
        -> where('c.clie_estado', 1)
        -> join('usuario u', 'u.usua_id = c.clie_usua_id')
        -> get() -> getResultArray();
    }

    public function getUsuario(){
        return $this -> db -> table('usuario u')
        -> where('u.usua_estado', 1)
        -> get() -> getResultArray();
    }
}