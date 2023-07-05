<?php   
namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\UsuariosModel;
use App\Models\RegistrosModel;
class Usuarios extends Controller{

    public function index(){

        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $headers = $request->getHeaders();
        $model = new RegistrosModel();
        $registro = $model->where('reg_estado', 1) -> findAll();
        
        foreach($registro as $key => $value){
            if(array_key_exists('Authorization',$headers)&& !empty($headers['Authorization'])){
                if($request -> getHeader('Authorization') == 'Authorization: Basic '
                .base64_encode($value['reg_clientes_id'].':'.$value['reg_llave_secreta'])){
                    $model = new UsuariosModel();
                    $usuarios = $model -> getUsuarios();
                    if(!empty($usuarios)){
                        $data = array(
                            "Status" => 200, 
                            "Total de registros" => count($usuarios),
                            "Detalles" => $usuarios
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
        $model = new RegistrosModel();
        $registro = $model -> where('reg_estado', 1) -> findAll();
        
        foreach($registro as $key => $value){
            if(array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])){
                if($request -> getHeader('Authorization') == 'Authorization: Basic '
                .base64_encode($value['reg_clientes_id'].':'.$value['reg_llave_secreta'])){
                    $model = new UsuariosModel();

                    if(is_numeric($id)){
                        $usuarios = $model -> getId($id);
                    }else if(is_string($id)){
                        $usuarios = $model -> getLogin($id);
                    }
                    //var_dump($curso); die;
                    if(!empty($usuarios)){
                        $data = array(
                            "Status" => 200,
                            "Detalles" => $usuarios
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
        $model = new RegistrosModel();
        $registro = $model -> where('reg_estado', 1) -> findAll();

        foreach($registro as $key => $value){
            if(array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])){
                if($request -> getHeader('Authorization') == 'Authorization: Basic '
                .base64_encode($value['reg_clientes_id'].':'.$value['reg_llave_secreta'])){
                        $datos = array(
                            "usu_usuario" => $request -> getVar("usu_usuario"),
                            "usu_clave" => $request -> getVar("usu_clave"),
                            "tiad_id" => $request -> getVar("tiad_id"),
                            "usu_nombres" => $request -> getVar("usu_nombres"),
                            "usu_apellidos" => $request -> getVar("usu_apellidos"),
                            "usu_usuario_token" => $request -> getVar("usu_usuario_token"),
                            "usu_llave_secreta" => $request -> getVar("usu_llave_secreta")
                        );
                        if(!empty($datos)){
                            $validation -> setRules([
                                'usu_usuario' => 'required|string|max_length[100]',
                                'usu_clave' => 'required|string|max_length[100]',
                                'tiad_id' => 'required|integer',
                                'usu_nombres' => 'required|string|max_length[255]',
                                'usu_apellidos' => 'required|string|max_length[255]',
                                'usu_usuario_token' => 'required|string|max_length[255]',
                                'usu_llave_secreta' => 'required|string|max_length[255]'
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
                                    "usu_usuario" =>  $datos["usu_usuario"],
                                    "usu_clave" =>  $datos["usu_clave"],
                                    "tiad_id" => $datos["tiad_id"],
                                    "usu_nombres" => $datos["usu_nombres"],
                                    "usu_apellidos" => $datos["usu_apellidos"],
                                    "usu_usuario_token" => $datos["usu_usuario_token"],
                                    "usu_llave_secreta" => $datos["usu_llave_secreta"],
                                );
                                $model = new UsuariosModel();
                                $usuarios = $model -> insert($datos);
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
        $model = new RegistrosModel();
        $registro = $model -> where('reg_estado', 1) -> findAll();
        foreach($registro as $key => $value){
            if(array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])){
                if($request -> getHeader('Authorization') == 'Authorization: Basic '
                .base64_encode($value['reg_clientes_id'].':'.$value['reg_llave_secreta'])){
                    $datos = $this -> request -> getRawInput();
                    if(!empty($datos)){
                        $validation -> setRules([
                            'usu_usuario' => 'required|string|max_length[100]',
                            'usu_clave' => 'required|string|max_length[100]',
                            'tiad_id' => 'required|integer',
                            'usu_nombres' => 'required|string|max_length[255]',
                            'usu_apellidos' => 'required|string|max_length[255]',
                            'usu_usuario_token' => 'required|string|max_length[255]',
                            'usu_llave_secreta' => 'required|string|max_length[255]'
                            
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
                            $model = new UsuariosModel();
                            $usuarios = $model -> find($id);
                            if(is_null($usuarios)){
                                $data = array(
                                    "Status" => 404,
                                    "Detalles" => "Registro no existe"
                                );
                                return json_encode($data, true);
                            }else{
                                $datos = array(
                                    "usu_usuario" =>  $datos["usu_usuario"],
                                    "usu_clave" =>  $datos["usu_clave"],
                                    "tiad_id" => $datos["tiad_id"],
                                    "usu_nombres" => $datos["usu_nombres"],
                                    "usu_apellidos" => $datos["usu_apellidos"],
                                    "usu_usuario_token" => $datos["usu_usuario_token"],
                                    "usu_llave_secreta" => $datos["usu_llave_secreta"]
                                );
                                $model = new UsuariosModel();
                                $platos = $model -> update($id, $datos);
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
        $model = new RegistrosModel();
        $registro = $model -> where('reg_estado', 1) -> findAll();
        
        foreach($registro as $key => $value){
            if(array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])){
                if($request -> getHeader('Authorization') == 'Authorization: Basic '
                .base64_encode($value['reg_clientes_id'].':'.$value['reg_llave_secreta'])){
                    $model = new UsuariosModel();
                    $platos = $model -> where('usu_estado',1) -> find($id);
                    //var_dump($curso); die;
                    if(!empty($platos)){
                        $datos = array(
                            "usu_estado" => 0
                        );
                        $platos = $model -> update($id, $datos);
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
