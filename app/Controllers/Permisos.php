<?php   
namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\PermisosModel;
use App\Models\RegistrosModel;
class Permisos extends Controller{

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
                    $model = new PermisosModel();
                    $Permisos = $model -> getPermisos();
                    if(!empty($Permisos)){
                        $data = array(
                            "Status" => 200, 
                            "Total de registros" => count($Permisos),
                            "Detalles" => $Permisos
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
                    $model = new PermisosModel();
                    $Permisos = $model -> getId($id);
                    //var_dump($curso); die;
                    if(!empty($Permisos)){
                        $data = array(
                            "Status" => 200,
                            "Detalles" => $Permisos
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
        //var_dump($registro); die;
        foreach($registro as $key => $value){
            if(array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])){
                if($request -> getHeader('Authorization') == 'Authorization: Basic '
                .base64_encode($value['reg_clientes_id'].':'.$value['reg_llave_secreta'])){
                        $datos = array(
                            "perm_tipo" => $request -> getVar("perm_tipo"),
                            "pern_descripcion" => $request -> getVar("pern_descripcion"),
                            "usu_id" => $request -> getVar("usu_id")
                        );
                        
                        if(!empty($datos)){
                            $validation -> setRules([
                                "perm_tipo" => 'required|string|max_length[100]',
                                "pern_descripcion" => 'required|string|max_length[255]',
                                "usu_id" => 'required|integer'

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
                                    "perm_tipo" => $datos["perm_tipo"],
                                    "pern_descripcion" => $datos["pern_descripcion"],
                                    "usu_id" => $datos["usu_id"]
                                );
                                $model = new PermisosModel();
                                $Permisos = $model -> insert($datos);
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
                                "perm_tipo" => 'required|string|max_length[100]',
                                "pern_descripcion" => 'required|string|max_length[255]',
                                "usu_id" => 'required|integer'
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
                            $model = new PermisosModel();
                            $Permisos = $model -> find($id);
                            if(is_null($Permisos)){
                                $data = array(
                                    "Status" => 404,
                                    "Detalles" => "Registro no existe"
                                );
                                return json_encode($data, true);
                            }else{
                                $datos = array(
                                    "perm_tipo" => $datos["perm_tipo"],
                                    "pern_descripcion" => $datos["pern_descripcion"],
                                    "usu_id" => $datos["usu_id"]
                                );
                                $model = new PermisosModel();
                                $Permisos = $model -> update($id, $datos);
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
                    $model = new PermisosModel();
                    $Permisos = $model -> where('perm_estado',1) -> find($id);
                    //var_dump($curso); die;
                    if(!empty($Permisos)){
                        $datos = array(
                            "perm_estado" => 0
                        );
                        $Permisos = $model -> update($id, $datos);
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