<?php   
namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\ComprobanteModel;
use App\Models\UsuarioModel;
class Comprobante extends Controller{

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
                    $model = new comprobanteModel();
                    $comprobante = $model -> getComprobante();
                    if(!empty($comprobante)){
                        $data = array(
                            "Status" => 200, 
                            "Total de registros" => count($comprobante),
                            "Detalles" => $comprobante
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
                    $model = new comprobanteModel();
                    $comprobante = $model -> getId($id);
                    //var_dump($curso); die;
                    if(!empty($comprobante)){
                        $data = array(
                            "Status" => 200,
                            "Detalles" => $comprobante
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
                            "comp_rest_id" => $request -> getVar("comp_rest_id"),
                            "comp_clie_id" => $request -> getVar("comp_clie_id"),
                            "comp_pedi_id" => $request -> getVar("comp_pedi_id"),
                            "comp_serie" => $request -> getVar("comp_serie"),
                            "comp_numeracion" => $request -> getVar("comp_numeracion"),
                            "comp_fecha" => $request -> getVar("comp_fecha"),
                            "comp_subtotal" => $request -> getVar("comp_subtotal"),
                            "comp_igv" => $request -> getVar("comp_igv"),
                            "comp_total" => $request -> getVar("comp_total")
                        );
                        if(!empty($datos)){
                            $validation -> setRules([
                                "comp_rest_id" => 'required|integer',
                                "comp_clie_id" => 'required|integer',
                                "comp_pedi_id" => 'required|integer',
                                "comp_serie" => 'required|integer',
                                "comp_numeracion" => 'required|integer',
                                "comp_fecha" => 'required|Date',
                                "comp_subtotal" => 'required|integer',
                                "comp_igv" => 'required|integer',
                                "comp_total" => 'required|integer'
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
                                    "comp_rest_id" => $datos["comp_rest_id"],
                                    "comp_clie_id" => $datos["comp_clie_id"],
                                    "comp_pedi_id" => $datos["comp_pedi_id"],
                                    "comp_serie" => $datos["comp_serie"],
                                    "comp_numeracion" => $datos["comp_numeracion"],
                                    "comp_fecha" => $datos["comp_fecha"],
                                    "comp_subtotal" => $datos["comp_subtotal"],
                                    "comp_igv" => $datos["comp_igv"],
                                    "comp_total" => $datos["comp_total"]
                                );
                                $model = new comprobanteModel();
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
                            "comp_rest_id" => 'required|integer',
                            "comp_clie_id" => 'required|integer',
                            "comp_pedi_id" => 'required|integer',
                            "comp_serie" => 'required|integer',
                            "comp_numeracion" => 'required|integer',
                            "comp_fecha" => 'required|Date',
                            "comp_subtotal" => 'required|integer',
                            "comp_igv" => 'required|integer',
                            "comp_total" => 'required|integer'
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
                            $model = new comprobanteModel();
                            $comprobante = $model -> find($id);
                            if(is_null($comprobante)){
                                $data = array(
                                    "Status" => 404,
                                    "Detalles" => "Registro no existe"
                                );
                                return json_encode($data, true);
                            }else{
                                $datos = array(
                                    "comp_rest_id" => $datos["comp_rest_id"],
                                    "comp_clie_id" => $datos["comp_clie_id"],
                                    "comp_pedi_id" => $datos["comp_pedi_id"],
                                    "comp_serie" => $datos["comp_serie"],
                                    "comp_numeracion" => $datos["comp_numeracion"],
                                    "comp_fecha" => $datos["comp_fecha"],
                                    "comp_subtotal" => $datos["comp_subtotal"],
                                    "comp_igv" => $datos["comp_igv"],
                                    "comp_total" => $datos["comp_total"]
                                );
                                $model = new comprobanteModel();
                                $comprobante = $model -> update($id, $datos);
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
                    $model = new comprobanteModel();
                    $comprobante = $model -> where('comp_estado',1) -> find($id);
                    //var_dump($curso); die;
                    if(!empty($comprobante)){
                        $datos = array(
                            "comp_estado" => 0
                        );
                        $comprobante = $model -> update($id, $datos);
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