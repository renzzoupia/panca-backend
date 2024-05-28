<?php   
namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\UsuarioModel;
class Usuario extends Controller{
    public function index(){
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

    public function show($id){
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $headers = $request -> getHeaders();
        
        $model = new UsuarioModel();

        if(is_numeric($id)){
            $usuario = $model -> getId($id);
        }else if(is_string($id)){
            $usuario = $model -> getLogin($id);
        }
        //var_dump($curso); die;
        if(!empty($usuario)){

            $data = array(
                "Status" => 200,
                "Detalles" => $usuario
            );
        }else{
            $data = array(
                "Status" => 404,
                "Detalles" => "No hay registros"
            );
        }
        return json_encode($data, true);
    }

    public function create(){
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $datos = array(
            "usua_tius_id" => $request -> getVar("usua_tius_id"),
            "usua_username" => $request -> getVar("usua_username"),
            "usua_pass" => $request -> getVar("usua_pass"),
            //"usua_user_secreto" => $request -> getVar("usua_user_secreto"),
            //"usua_llave_secreta" => $request -> getVar("usua_llave_secreta")
        );
        if(!empty($datos)){
            $validation -> setRules([
                'usua_tius_id' => 'required|string|required|integer',
                'usua_username' => 'required|string|max_length[100]',
                'usua_pass' => 'required|string|max_length[100]',
                //'usua_user_secreto' => 'required|string|max_length[255]',
                //'usua_llave_secreta' => 'required|string|max_length[255]'
            ]);
            $validation -> withRequest($this -> request) -> run();
            if($validation -> getErrors()){
                $errors = $validation ->getErrors();
                $data = array(
                    "Status" => 404,
                    "Detalle"=>$errors
                );
                return json_encode($data, true);
            }else{
                $usua_pass = crypt($datos["usua_pass"], '2a07dfhdfrexfhgdfhdferttgsad');
                $usua_user_secreto = crypt($datos["usua_username"].$datos["usua_pass"], '$2a$07$dfhdfrexfhgdfhdferttgsad$');
	     		$usua_llave_secreta = crypt($datos["usua_pass"].$datos["usua_username"], '$2a$07$dfhdfrexfhgdfhdferttgsad$');
                $datos = array(
                    "usua_tius_id" => $datos["usua_tius_id"],
                    "usua_username" => $datos["usua_username"],
                    "usua_pass" => $datos["usua_pass"],
                    "usua_user_secreto" => $usua_user_secreto,
                    "usua_llave_secreta" => $usua_llave_secreta
                );
                $model = new UsuarioModel();
                $registro = $model -> insert($datos);
                $data = array(
                    "Status" => 200,
                    "Detalle" => "Registro OK, guarde sus credenciales",
                    "credenciales" => array(
                        "usua_id" => $registro,
                        "reg_clientes_id" => str_replace('$','a',$usua_user_secreto),
                        "reg_llave_secreta" => str_replace('$','o',$usua_llave_secreta)
                    )
                );
                return json_encode($data, true);
            }
        }else{
            $data = array(
                "Status" => 400,
                "Detalle" => "Registro con errores"
            );
            return json_encode($data, true);
        }
    }

    public function update($id){
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $headers = $request -> getHeaders();
        $datos = $this -> request -> getRawInput();
        if(!empty($datos)){
            $validation -> setRules([
                'usua_tius_id' => 'required|integer',
                'usua_username' => 'required|string|max_length[100]',
                'usua_pass' => 'required|string|max_length[100]'
            ]);
            $validation -> withRequest(
                $this -> request
            ) -> run();
            if($validation -> getErrors()){
                $errors = $validation -> getErrors();
                $data = array(
                    "Status" => 404,
                    "Detalles" => $errors
                );
                return json_encode($data, true);
            }else{
                $model = new UsuarioModel();
                $usuario = $model -> find($id);
                if(is_null($usuario)){
                    $data = array(
                        "Status" => 404,
                        "Detalles" => "Registro no existe"
                    );
                    return json_encode($data, true);
                }else{      // encriptamiento lo editado
                    $usua_pass = crypt($datos["usua_pass"].$datos["usua_username"], '2a07dfhdfrexfhgdfhdferttgsad');
                    $usua_user_secreto = crypt($datos["usua_username"].$datos["usua_pass"], '$2a$07$dfhdfrexfhgdfhdferttgsad$');
    	     		$usua_llave_secreta = crypt($datos["usua_pass"].$datos["usua_username"], '$2a$07$dfhdfrexfhgdfhdferttgsad$');

                    $datos = array(
                        "usua_tius_id" => $datos["usua_tius_id"],
                        "usua_username" => $datos["usua_username"],
                        "usua_pass" => $datos["usua_pass"],
                        "usua_user_secreto" => str_replace('$','a',$usua_user_secreto),
                        "usua_llave_secreta" => str_replace('$','a',$usua_llave_secreta)
                    );
                    $model = new UsuarioModel();
                    $usuario = $model -> update($id, $datos);
                    $data = array(
                        "Status" => 200,
                        "Detalles" => "Datos actualizados",
                        "Nuevas credenciales" => array(
                            "reg_clientes_id" => str_replace('$','a',$usua_user_secreto),
                            "reg_llave_secreta" => str_replace('$','o',$usua_llave_secreta)
                        )
                    );
                }
            }
        }else{
            $data = array(
                "Status" => 400,
                "Detalles" => "Registro con errores"
            );
            return json_encode($data, true);
        }
                
        return json_encode($data, true);
    }


    public function delete($id){
        $request = \Config\Services::request();
        $validation = \Config\Services::validation();
        $headers = $request -> getHeaders();
        $model = new UsuarioModel();
        $usuario = $model -> where('usua_estado',1) -> find($id);
        if(!empty($usuario)){
            $datos = array(
                "usua_estado" => 0
            );
            $usuario = $model -> update($id, $datos);
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
    }
}
