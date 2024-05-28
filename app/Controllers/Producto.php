<?php   
namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\ProductoModel;
use App\Models\UsuarioModel;
class Producto extends Controller{

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
                    $model = new ProductoModel();
                    $producto = $model -> getProducto();
                    if(!empty($producto)){
                        $data = array(
                            "Status" => 200, 
                            "Total de registros" => count($producto),
                            "Detalles" => $producto
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
                    $model = new ProductoModel();
                    $producto = $model -> getId($id);
                    //var_dump($curso); die;
                    if(!empty($producto)){
                        $data = array(
                            "Status" => 200,
                            "Detalles" => $producto
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
                            "prod_tipr_id" => $request -> getVar("prod_tipr_id"),
                            "prod_nombre" => $request -> getVar("prod_nombre"),
                            "prod_descripcion" => $request -> getVar("prod_descripcion"),
                            "prod_stock" => $request -> getVar("prod_stock"),
                            "prod_precio" => $request -> getVar("prod_precio"),
                            "prod_foto" => $request -> getFile("prod_foto")
                        );
                        $logo = $datos['prod_foto']; 
                        $empresa2 = intval($datos['prod_nombre']);

                        if(!empty($datos)){
                            $validation -> setRules([
                                "prod_tipr_id" => 'required|integer',
                                "prod_nombre" => 'required|string|max_length[100]',
                                "prod_descripcion" => 'required|string|max_length[255]',
                                "prod_stock" => 'required|integer',
                                "prod_precio" => 'required|decimal',
                                //"prod_foto" => 'required|string|max_length[255]'
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
                                $newName = $logo->getRandomName();
                                $datos = array(
                                    "prod_tipr_id" => $datos["prod_tipr_id"],
                                    "prod_nombre" => $datos["prod_nombre"],
                                    "prod_descripcion" => $datos["prod_descripcion"],
                                    "prod_stock" => $datos["prod_stock"],
                                    "prod_precio" => $datos["prod_precio"],
                                    "prod_foto" => "https://panca.informaticapp.com/public/Productos/".$newName
                                );
                                $model = new ProductoModel();
                                $prod_id = $model -> insert($datos);
                                $data = array(
                                    "Status" => 200,
                                    "Detalles" => "Registro existoso",
                                    "prod_id" => $prod_id
                                );
                                //Subir archivo
                                $model2 = new ProductoModel;
                                //$empresa = $model2->getProducto($empresa2);
                                if($logo->isValid() && !$logo->hasMoved()) {
                                    // Directorio de destino
                                    $uploadPath = './public/Productos';
                        
                                    // Generar un nombre de archivo único
                        
                                    // Mover el archivo al directorio de destino
                                    $logo->move($uploadPath, $newName);
                        
                                    // Enviar una respuesta JSON con la ubicación del archivo
                                    $response = [
                                        'status' => 'success',
                                        'message' => 'Archivo subido correctamente',
                                        'logo$logo_path' => base_url($uploadPath."/".$newName)
                                    ];
                        
                                    $up = $this->response->setJSON($response);
                                } else {
                                    // Si hay un error en la carga del archivo
                                    $response = [
                                        'status' => 'error',
                                        'message' => $logo->getErrorString()
                                    ];
                                  $up =  $this->response->setJSON($response);
                                }


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
                            "prod_tipr_id" => 'required|integer',
                            "prod_nombre" => 'required|string|max_length[100]',
                            "prod_descripcion" => 'required|string|max_length[255]',
                            "prod_stock" => 'required|integer',
                            "prod_precio" => 'required|decimal',
                            "prod_foto" => 'required|string|max_length[255]'
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
                            $model = new ProductoModel();
                            $producto = $model -> find($id);
                            if(is_null($producto)){
                                $data = array(
                                    "Status" => 404,
                                    "Detalles" => "Registro no existe"
                                );
                                return json_encode($data, true);
                            }else{
                                $datos = array(
                                    "prod_tipr_id" => $datos["prod_tipr_id"],
                                    "prod_nombre" => $datos["prod_nombre"],
                                    "prod_descripcion" => $datos["prod_descripcion"],
                                    "prod_stock" => $datos["prod_stock"],
                                    "prod_precio" => $datos["prod_precio"],
                                    "prod_foto" => $datos["prod_foto"]
                                );
                                $model = new ProductoModel();
                                $producto = $model -> update($id, $datos);
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
                    $model = new ProductoModel();
                    $producto = $model -> where('prod_estado',1) -> find($id);
                    //var_dump($curso); die;
                    if(!empty($producto)){
                        $datos = array(
                            "prod_estado" => 0
                        );
                        $producto = $model -> update($id, $datos);
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