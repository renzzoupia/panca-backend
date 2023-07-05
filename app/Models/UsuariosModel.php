<?php
namespace App\Models;
use CodeIgniter\Model;
class UsuariosModel extends Model{
    protected $table = 'usuarios';
    protected $primaryKey = 'usu_id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'usu_usuario',
        'usu_clave',
        'tiad_id',
        'usu_estado',
        'usu_nombres',
        'usu_apellidos',
        'usu_usuario_token',
        'usu_llave_secreta'
    ];

    public function getUsuarios(){
        return $this -> db -> table('usuarios u')
        -> where('u.usu_estado', 1)
        -> join('tipo_admin ta', 'u.tiad_id = ta.tiad_id')
        -> get() -> getResultArray();
    }

    public function getId($id){
        return $this -> db -> table('usuarios u')
        -> where('u.usu_id', $id)
        -> where('u.usu_estado', 1)
        -> join('tipo_admin ta', 'u.tiad_id = ta.tiad_id')
        -> get() -> getResultArray();
    }

    public function getLogin($usu){
        $usuario = explode('&', $usu);
        if(count($usuario) == 2){
            $usuarios = $usuario[0];
            $password = $usuario[1];
            //$sucursal = $usuario[2];
            return $this -> db -> table('usuarios u')
            ->where('u.usu_usuario', $usuarios)
            ->where('u.usu_clave', $password)
            //->where('u.sucu_id', $sucursal)
            ->where('u.usu_estado', 1)
            ->join('tipo_admin ta', 'ta.tiad_id = u.tiad_id')
            ->get()->getResultArray();
        }else{
            return 'El usuario no es valido';
        }
    }

    public function getTipoAdmin(){
        return $this -> db -> table('tipo_admin ta')
        -> where('ta.tiad_estado', 1)
        -> get() -> getResultArray();
    }
}