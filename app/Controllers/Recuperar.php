<?php   
namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\ClienteModel;
class Recuperar extends Controller{

    public function create(){

        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $headers = $request->getHeaders();
        $model = new ClienteModel();
        $registro = $model -> where('clie_estado', 1) -> getCliente();
        foreach($registro as $key => $value){
            if(array_key_exists('Correo', $headers) && !empty($headers['Correo'])){
                if($request -> getHeader('Correo') == 'Correo: '.$value['clie_correo']){
                    $data = array(
                        "Status" => 200,
                        "Detalles" => "Correo encontrado",
                        "Datos" => $value
                    );
                    return json_encode($data, true);
                }else{
                    $data = array(
                        "Status" => 404,
                        "Detalles" => "Correo no encontrado"
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
