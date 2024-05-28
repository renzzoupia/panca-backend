<?php   
namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\ReservaModel;
use App\Models\UsuarioModel;
class ReservaFiltrada extends Controller{

    public function show($id){
        $model = new ReservaModel();
        $reserva = $model -> obtenerReservasPorCliente($id);
        //var_dump($curso); die;
        if(!empty($reserva)){
            $data = array(
                "Status" => 200,
                "Total de registros" => count($reserva),
                "Detalles" => $reserva
            );
        }else{
            $data = array(
                "Status" => 404,
                "Detalles" => "No hay registros con ese id"
            );
        }
        return json_encode($data, true);
   
    }
}