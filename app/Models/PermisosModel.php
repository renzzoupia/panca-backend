<?php
namespace App\Models;
use CodeIgniter\Model;
class PermisosModel extends Model{
    protected $table = 'permisos';
    protected $primaryKey = 'perm_id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'perm_tipo',
        'pern_descripcion',
        'usu_id',
        'perm_estado'
    ];

    public function getPermisos(){
        return $this -> db -> table('permisos p')
        -> where('p.perm_estado', 1)
        -> join('usuarios u', 'p.usu_id = u.usu_id')
        -> get() -> getResultArray();
    }

    public function getId($id){
        return $this -> db -> table('permisos p')
        -> where('p.perm_id', $id)
        -> where('p.perm_estado', 1)
        -> join('usuarios u', 'p.usu_id = u.usu_id')
        -> get() -> getResultArray();
    }

    public function getUsuarios(){        
        return $this -> db -> table('usuarios u')
        -> where('u.usu_estado', 1)
        -> get() -> getResultArray();
    }
}