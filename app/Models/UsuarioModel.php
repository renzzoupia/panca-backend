<?php
namespace App\Models;
use CodeIgniter\Model;
class UsuarioModel extends Model{
    protected $table = 'usuario';
    protected $primaryKey = 'usua_id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'usua_tius_id',
        'usua_username',
        'usua_pass',
        'usua_user_secreto',
        'usua_llave_secreta',
        'usua_estado'
    ];

    public function getUsuario(){
        return $this -> db -> table('usuario u')
        -> where('u.usua_estado', 1)
        -> join('tipo_usuario tu', 'u.usua_tius_id = tu.tius_id')
        -> get() -> getResultArray();
    }

    public function getId($id){
        return $this -> db -> table('usuario u')
        -> where('u.usua_id', $id)
        -> where('u.usua_estado', 1)
        -> join('tipo_usuario tu', 'u.usua_tius_id = tu.tius_id')
        -> get() -> getResultArray();
    }

    public function getLogin($usu){
        $usuario = explode('&', $usu);
        if(count($usuario) == 2){
            $usuarios = $usuario[0];
            $password = $usuario[1];
            //$sucursal = $usuario[2];
            return $this -> db -> table('usuario u')
            ->where('u.usua_username', $usuarios)
            ->where('u.usua_pass', $password)
            ->where('u.usua_estado', 1)
            ->join('tipo_usuario tu', 'u.usua_tius_id = tu.tius_id')
            ->get()->getResultArray();
        }else{
            return 'El usuario no es valido';
        }
    }
    public function getTipoUsuario(){
        return $this -> db -> table('tipo_usuario tu')
        -> where('tu.tius_estado', 1)
        -> get() -> getResultArray();
    }
}