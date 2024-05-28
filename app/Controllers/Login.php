<?php   
namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\ClienteModel;
class Login extends Controller{

    public function create(){

        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $headers = $request->getHeaders();
        $model = new ClienteModel();
        $registro = $model -> where('clie_estado', 1) -> getCliente();
        foreach($registro as $key => $value){
            if(array_key_exists('Usuario', $headers) && !empty($headers['Usuario']) && array_key_exists('Contra', $headers) && !empty($headers['Contra'])){
                if($request -> getHeader('Usuario') == 'Usuario: '.$value['usua_username']){
                    if($request -> getHeader('Contra') == 'Contra: '.$value['usua_pass']){
                        $data = array(
                            "Status" => 200,
                            "Detalles" => "Logeado correctamente",
                            "Datos" => $value
                        );
                    return json_encode($data, true);
                    }
                        $data = array(
                            "Status" => 404,
                            "Detalles" => "Contrasena incorrecta"
                        );
                    return json_encode($data, true);
                }else{
                    $data = array(
                        "Status" => 404,
                        "Detalles" => "Usuario incorrecto"
                    );
                }
            }else{
                $data = array(
                    "Status" => 404,
                    "Detalles" => "No ingreso datos"
                );
            }    
        }
        return json_encode($data, true);
    }
    

}
