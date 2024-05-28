<?php
namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\UsuarioModel;
namespace App\Controllers;

class Admin extends Controller
{
    public function login()
    {
        
        $model = new UsuarioModel();
        $registro = $model -> getUsuario();
        //var_dump($registro); die;
        if(count($registro) == 0){
            $respuesta = array(
                "error" => true,
                "mensaje" => "No hay elemento"
            );
            $data = json_encode($respuesta);
            //var_dump($respuesta); die;
            
        }else{
            $respuesta = array(
                "Status" => 200,
                "Total de registros" => count($registro),
                "Detalles" => $registro
            );
            $data = json_encode($respuesta);
        }
        return $data;
    }
}
