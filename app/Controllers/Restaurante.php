<?php   
namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\RestauranteModel;
use App\Models\UsuarioModel;
class Restaurante extends Controller{

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
                    $model = new RestauranteModel();
                    $restaurante = $model -> getRestaurante();
                    if(!empty($restaurante)){
                        $data = array(
                            "Status" => 200, 
                            "Total de registros" => count($restaurante),
                            "Detalles" => $restaurante
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
                    $model = new RestauranteModel();
                    $restaurante = $model -> getId($id);
                    //var_dump($curso); die;
                    if(!empty($restaurante)){
                        $data = array(
                            "Status" => 200,
                            "Detalles" => $restaurante
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
                            "rest_usua_id" => $request -> getVar("rest_usua_id"),
                            "rest_razon_social" => $request -> getVar("rest_razon_social"),
                            "rest_ruc" => $request -> getVar("rest_ruc"),
                            "rest_descrip" => $request -> getVar("rest_descrip"),
                            "rest_direccion" => $request -> getVar("rest_direccion"),
                            "rest_telefono" => $request -> getVar("rest_telefono"),
                            "rest_horario" => $request -> getVar("rest_horario")
                        );
                        if(!empty($datos)){
                            $validation -> setRules([
                                "rest_usua_id" => 'required|integer',
                                "rest_razon_social" => 'required|string|max_length[100]',
                                "rest_ruc" => 'required|integer',
                                "rest_descrip" => 'required|string|max_length[100]',
                                "rest_direccion" => 'required|string|max_length[100]',
                                "rest_telefono" => 'required|string|max_length[100]',
                                "rest_horario" => 'required|string|max_length[100]'
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
                                    "rest_usua_id" => $datos["rest_usua_id"],
                                    "rest_razon_social" => $datos["rest_razon_social"],
                                    "rest_ruc" => $datos["rest_ruc"],
                                    "rest_descrip" => $datos["rest_descrip"],
                                    "rest_direccion" => $datos["rest_direccion"],
                                    "rest_telefono" => $datos["rest_telefono"],
                                    "rest_horario" => $datos["rest_horario"]
                                );
                                $model = new RestauranteModel();
                                $curso = $model -> insert($datos);
                                $data = array(
                                    "Status" => 200,
                                    "Detalles" => "Registro existoso"
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
                                "rest_usua_id" => 'required|integer',
                                "rest_razon_social" => 'required|string|max_length[100]',
                                "rest_ruc" => 'required|integer',
                                "rest_descrip" => 'required|string|max_length[100]',
                                "rest_direccion" => 'required|string|max_length[100]',
                                "rest_telefono" => 'required|string|max_length[100]',
                                "rest_horario" => 'required|string|max_length[100]'
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
                            $model = new RestauranteModel();
                            $restaurante = $model -> find($id);
                            if(is_null($restaurante)){
                                $data = array(
                                    "Status" => 404,
                                    "Detalles" => "Registro no existe"
                                );
                                return json_encode($data, true);
                            }else{
                                $datos = array(
                                    "rest_usua_id" => $datos["rest_usua_id"],
                                    "rest_razon_social" => $datos["rest_razon_social"],
                                    "rest_ruc" => $datos["rest_ruc"],
                                    "rest_descrip" => $datos["rest_descrip"],
                                    "rest_direccion" => $datos["rest_direccion"],
                                    "rest_telefono" => $datos["rest_telefono"],
                                    "rest_horario" => $datos["rest_horario"]
                                );
                                $model = new RestauranteModel();
                                $restaurante = $model -> update($id, $datos);
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
                    $model = new RestauranteModel();
                    $restaurante = $model -> where('rest_estado',1) -> find($id);
                    //var_dump($curso); die;
                    if(!empty($restaurante)){
                        $datos = array(
                            "rest_estado" => 0
                        );
                        $restaurante = $model -> update($id, $datos);
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