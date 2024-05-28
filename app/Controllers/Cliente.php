<?php   
namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\ClienteModel;
use App\Models\UsuarioModel;
class Cliente extends Controller{

    public function index(){
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $headers = $request->getHeaders();
        $model = new UsuarioModel();
        $registro = $model -> where('usua_estado', 1) -> findAll();
        
        foreach($registro as $key => $value){
            if(array_key_exists('Authorization',$headers)&& !empty($headers['Authorization'])){
                if($request -> getHeader('Authorization') == 'Authorization: Basic '
                .base64_encode($value['usua_user_secreto'].':'.$value['usua_llave_secreta'])){
                    $model = new ClienteModel();
                    $cliente = $model -> getCliente();
                    if(!empty($cliente)){
                        $data = array(
                            "Status" => 200, 
                            "Total de registros" => count($cliente),
                            "Detalles" => $cliente
                        );
                    }else{
                        $data = array(
                            "Status" => 404,
                            "Total de registros" => 0,
                            "Detalles" => "No hay registros"
                        );
                    }
                    return json_encode($data, true);
                }else{
                    $data = array(
                        "Status" => 404,
                        "Detalles" => "El token es incorrecto"
                    );
                }
            }else{
                $data = array(
                    "Status" => 404,
                    "Detalles" => "No posee autorización"
                );
            }    
        }
        return json_encode($data, true);

    }

    public function show($id){
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $headers = $request -> getHeaders();
        $model = new UsuarioModel();
        $registro = $model->where('usua_estado', 1) -> findAll();
        
        foreach($registro as $key => $value){
            if(array_key_exists('Authorization',$headers)&& !empty($headers['Authorization'])){
                if($request -> getHeader('Authorization') == 'Authorization: Basic '
                .base64_encode($value['usua_user_secreto'].':'.$value['usua_llave_secreta'])){
                    $model = new ClienteModel();
                    $cliente = $model -> getId($id);
                    //var_dump($curso); die;
                    if(!empty($cliente)){
                        $data = array(
                            "Status" => 200,
                            "Detalles" => $cliente
                        );
                    }else{
                        $data = array(
                            "Status" => 404,
                            "Detalles" => "No hay registros"
                        );
                    }
                    return json_encode($data, true);
                }else{
                    $data = array(
                        "Status" => 404,
                        "Detalles" => "El token es incorrecto"
                    );
                }
            }else{
                $data = array(
                    "Status" => 404,
                    "Detalles" => "No posee autorización"
                );
            }    
        }
        return json_encode($data, true);
    }

    public function create(){
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $headers = $request -> getHeaders();
        $model = new UsuarioModel();
        $registro = $model->where('usua_estado', 1) -> findAll();
        //var_dump($registro); die;
        foreach($registro as $key => $value){
            if(array_key_exists('Authorization',$headers)&& !empty($headers['Authorization'])){
                if($request -> getHeader('Authorization') == 'Authorization: Basic '
                .base64_encode($value['usua_user_secreto'].':'.$value['usua_llave_secreta'])){
                        $datos = array(
                            "clie_usua_id" => $request -> getVar("clie_usua_id"),
                            "clie_nombres" => $request -> getVar("clie_nombres"),
                            "clie_apellidos" => $request -> getVar("clie_apellidos"),
                            "clie_dni" => $request -> getVar("clie_dni"),
                            "clie_celular" => $request -> getVar("clie_celular"),
                            "clie_correo" => $request -> getVar("clie_correo"),
                            "clie_foto" => $request -> getVar("clie_foto"),
                            "clie_direccion" => $request -> getVar("clie_direccion")
                        );
                        if(!empty($datos)){
                            $validation -> setRules([
                                "clie_usua_id" => 'required|integer',
                                "clie_nombres" => 'required|string|max_length[100]',
                                "clie_apellidos" => 'required|string|max_length[100]',
                                "clie_dni" => 'required|integer',
                                "clie_celular" => 'required|integer',
                                "clie_correo" => 'required|string|max_length[100]',
                                "clie_foto" => 'required|string|max_length[255]',
                                "clie_direccion" => 'required|string|max_length[255]'
                            ]);
                            $validation -> withRequest($this -> request) -> run();
                            if($validation -> getErrors()){
                                $errors = $validation -> getErrors();
                                $data = array(
                                    "Status" => 404,
                                    "Detalles" => $errors
                                );
                                return json_encode($data, true);
                            }else{
                                $datos = array(
                                    "clie_usua_id" => $datos["clie_usua_id"],
                                    "clie_nombres" => $datos["clie_nombres"],
                                    "clie_apellidos" => $datos["clie_apellidos"],
                                    "clie_dni" => $datos["clie_dni"],
                                    "clie_celular" => $datos["clie_celular"],
                                    "clie_correo" => $datos["clie_correo"],
                                    "clie_foto" => $datos["clie_foto"],
                                    "clie_direccion" => $datos["clie_direccion"]
                                );
                                $model = new ClienteModel();
                                $clie_id = $model -> insert($datos);
                                $data = array(
                                    "Status" => 200,
                                    "Detalles" => "Registro existoso",
                                    "clie_id" => $clie_id
                                );
                                return json_encode($data, true);
                            }
                        }else{
                            $data = array(
                                "Status" => 404,
                                "Detalles" => "Registro con errores"
                            );
                            return json_encode($data, true);
                        }
                }else{
                    $data = array(
                        "Status" => 404,
                        "Detalles" => "El token es incorrecto"
                    );
                }
            }else{
                $data = array(
                    "Status" => 404,
                    "Detalles" => "No posee autorización"
                );
            }
        }
        return json_encode($data, true);
    }

    public function update($id){
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $headers = $request -> getHeaders();
        $model = new UsuarioModel();
        $registro = $model->where('usua_estado', 1) -> findAll();
        foreach($registro as $key => $value){
            if(array_key_exists('Authorization',$headers)&& !empty($headers['Authorization'])){
                if($request -> getHeader('Authorization') == 'Authorization: Basic '
                .base64_encode($value['usua_user_secreto'].':'.$value['usua_llave_secreta'])){
                    $datos = $this -> request -> getRawInput();
                    if(!empty($datos)){
                        $validation -> setRules([
                                "clie_usua_id" => 'required|integer',
                                "clie_nombres" => 'required|string|max_length[100]',
                                "clie_apellidos" => 'required|string|max_length[100]',
                                "clie_dni" => 'required|integer',
                                "clie_celular" => 'required|integer',
                                "clie_correo" => 'required|string|max_length[100]',
                                "clie_foto" => 'required|string|max_length[255]',
                                "clie_direccion" => 'required|string|max_length[255]'
                        ]);
                        $validation -> withRequest($this -> request) -> run();
                        if($validation -> getErrors()){
                            $errors = $validation -> getErrors();
                            $data = array(
                                "Status" => 404,
                                "Detalles" => $errors
                            );
                            return json_encode($data, true);
                        }else{
                            $model = new ClienteModel();
                            $cliente = $model -> find($id);
                            if(is_null($cliente)){
                                $data = array(
                                    "Status" => 404,
                                    "Detalles" => "Registro no existe"
                                );
                                return json_encode($data, true);
                            }else{
                                $datos = array(
                                    "clie_usua_id" => $datos["clie_usua_id"],
                                    "clie_nombres" => $datos["clie_nombres"],
                                    "clie_apellidos" => $datos["clie_apellidos"],
                                    "clie_dni" => $datos["clie_dni"],
                                    "clie_celular" => $datos["clie_celular"],
                                    "clie_correo" => $datos["clie_correo"],
                                    "clie_foto" => $datos["clie_foto"],
                                    "clie_direccion" => $datos["clie_direccion"]
                                );
                                $model = new ClienteModel();
                                $cliente = $model -> update($id, $datos);
                                $data = array(
                                    "Status" => 200,
                                    "Detalles" => "Datos actualizados"
                                );
                                return json_encode($data, true);
                            }
                        }
                    }else{
                        $data = array(
                            "Status" => 400,
                            "Detalles" => "Registro con errores"
                        );
                        return json_encode($data, true);
                    }
                }else{
                    $data = array(
                        "Status" => 404,
                        "Detalles" => "El token es incorrecto"
                    );
                }
            }else{
                $data = array(
                    "Status" => 404,
                    "Detalles" => "No posee autorización"
                );
            }
        }
        return json_encode($data, true);
    }

    public function delete($id){
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $headers = $request -> getHeaders();
        $model = new UsuarioModel();
        $registro = $model->where('usua_estado', 1) -> findAll();
        
        foreach($registro as $key => $value){
            if(array_key_exists('Authorization',$headers)&& !empty($headers['Authorization'])){
                if($request -> getHeader('Authorization') == 'Authorization: Basic '
                .base64_encode($value['usua_user_secreto'].':'.$value['usua_llave_secreta'])){
                    $model = new ClienteModel();
                    $cliente = $model -> where('clie_estado',1) -> find($id);
                    //var_dump($curso); die;
                    if(!empty($cliente)){
                        $datos = array(
                            "clie_estado" => 0
                        );
                        $cliente = $model -> update($id, $datos);
                        $data = array(
                            "Status" => 200, 
                            "Detalles" => "Se ha eliminado el registro"
                        );
                    }else{
                        $data = array(
                            "Status" => 404,
                            "Detalles" => "No hay registros"
                        );
                    }
                    return json_encode($data, true);
                }else{
                    $data = array(
                        "Status" => 404,
                        "Detalles" => "El token es incorrecto"
                    );
                }
            }else{
                $data = array(
                    "Status" => 404,
                    "Detalles" => "No posee autorización"
                );
            }    
        }
        return json_encode($data, true);
    }
}