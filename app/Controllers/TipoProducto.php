<?php   
namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\TipoProductoModel;
use App\Models\RegistrosModel;
class TipoProducto extends Controller{

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
                    $model = new TipoProductoModel();
                    $tipoproducto = $model -> where('tipr_estado',1)->findAll();
                    if(!empty($tipoproducto)){
                        $data = array(
                            "Status" => 200, 
                            "Total de registros" => count($tipoproducto),
                            "Detalles" => $tipoproducto
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
                    $model = new TipoProductoModel();
                    $tipoproducto = $model ->where('tipr_estado',1)->find($id);
                    //var_dump($curso); die;
                    if(!empty($tipoproducto)){
                        $data = array(
                            "Status" => 200,
                            "Detalles" => $tipoproducto
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
                            "tipr_tipo" => $request -> getVar("tipr_tipo"),
                            "tipr_descripcion" => $request -> getVar("tipr_descripcion")
                        );
                        if(!empty($datos)){
                            $validation -> setRules([
                                "tipr_tipo" => 'required|string|max_length[100]',
                                "tipr_descripcion" => 'required|string|max_length[100]'
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
                                    "tipr_tipo" => $datos["tipr_tipo"],
                                    "tipr_descripcion" => $datos["tipr_descripcion"]
                                );
                                $model = new TipoProductoModel();
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
        $model = new RegistrosModel();
        $registro = $model -> where('reg_estado', 1) -> findAll();
        foreach($registro as $key => $value){
            if(array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])){
                if($request -> getHeader('Authorization') == 'Authorization: Basic '
                .base64_encode($value['reg_clientes_id'].':'.$value['reg_llave_secreta'])){
                    $datos = $this -> request -> getRawInput();
                    if(!empty($datos)){
                        $validation -> setRules([
                            "tipr_tipo" => 'required|string|max_length[100]',
                            "tipr_descripcion" => 'required|string|max_length[100]'
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
                            $model = new TipoProductoModel();
                            $empresa = $model -> find($id);
                            if(is_null($empresa)){
                                $data = array(
                                    "Status" => 404,
                                    "Detalles" => "Registro no existe"
                                );
                                return json_encode($data, true);
                            }else{
                                $datos = array(
                                    "tipr_tipo" => $datos["tipr_tipo"],
                                    "tipr_descripcion" => $datos["tipr_descripcion"]
                                );
                                $model = new TipoProductoModel();
                                $empresa = $model -> update($id, $datos);
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
                    $model = new TipoProductoModel();
                    $tipoproducto = $model -> where('tipr_estado',1) -> find($id);
                    //var_dump($curso); die;
                    if(!empty($tipoproducto)){
                        $datos = array(
                            "tipr_estado" => 0
                        );
                        $tipoproducto = $model -> update($id, $datos);
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