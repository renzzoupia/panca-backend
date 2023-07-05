<?php
namespace App\Models;
use CodeIgniter\Model;
class ReservasModel extends Model{
    protected $table = 'reserva';
    protected $primaryKey = 'res_id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'per_id',
        'res_fecha_pedido',
        'res_fecha_reserva',
        'res_hora',
        'res_estado'
    ];

    public function getReservas(){
        return $this -> db -> table('reserva r')
        -> where('r.res_estado', 1)
        -> join('personas p', 'r.per_id = p.per_id')
        -> get() -> getResultArray();
    }

    public function getId($id){
        return $this -> db -> table('reserva r')
        -> where('r.res_id', $id)
        -> where('r.res_estado', 1)
        -> join('personas p', 'r.per_id = p.per_id')
        -> get() -> getResultArray();
    
    }

    public function getPersonas(){
        return $this -> db -> table('personas p')
        -> where('p.per_estado', 1)
        -> get() -> getResultArray();
    }
}