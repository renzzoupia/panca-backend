<?php
namespace App\Models;
use CodeIgniter\Model;
class ReservaModel extends Model{
    protected $table = 'reserva';
    protected $primaryKey = 'rese_id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'rese_mesa_id',
        'rese_clie_id',
        'rese_fecha',
        'rese_hora',
        'rese_personas',
        'rese_estado'
    ];

    public function getReserva(){
        return $this -> db -> table('reserva r')
        -> where('r.rese_estado', 1)
        -> join('mesa m', 'm.mesa_id = r.rese_mesa_id')
        -> join('cliente c', 'c.clie_id = r.rese_clie_id')
        -> get() -> getResultArray();
    }

    public function getId($id){
        return $this -> db -> table('reserva r')
        -> where('r.rese_id', $id)
        -> where('r.rese_estado', 1)
        -> join('mesa m', 'm.mesa_id = r.rese_mesa_id')
        -> join('cliente c', 'c.clie_id = r.rese_clie_id')
        -> get() -> getResultArray();
    }
    public function getMesa(){
        return $this -> db -> table('mesa m')
        -> where('m.mesa_estado', 1)
        -> get() -> getResultArray();
    }
    public function getCliente(){
        return $this -> db -> table('cliente c')
        -> where('c.clie_estado', 1)
        -> get() -> getResultArray();
    }

    public function obtenerReservasPorCliente($cliente_id) {
        // Realizar la consulta para obtener las reservas relacionadas al cliente
        return $this -> db -> table('reserva r')
        -> where('r.rese_estado', 1)
        -> where('r.rese_clie_id', $cliente_id)
        -> join('cliente c', 'c.clie_id = r.rese_clie_id')
        -> join('mesa m', 'm.mesa_id = r.rese_mesa_id')
        -> get() -> getResultArray();
    }
}