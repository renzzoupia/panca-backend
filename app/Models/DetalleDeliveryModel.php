<?php
namespace App\Models;
use CodeIgniter\Model;
class DetalleDeliveryModel extends Model{
    protected $table = 'detalle_delivery';
    protected $primaryKey = 'dede_id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'dede_pedi_id',
        'dede_direccion_entrega',
        'dede_referencia_direccion',
        'dede_estado_pedido',
        'dede_estado'
    ];

    public function getDetalleDelivery(){
        return $this -> db -> table('detalle_delivery dd')
        -> where('dd.dede_estado', 1)
        -> join('pedido p', 'p.pedi_id = dd.dede_pedi_id')
        -> get() -> getResultArray();
    }

    public function getId($id){
        return $this -> db -> table('detalle_delivery dd')
        -> where('dd.dede_id', $id)
        -> where('dd.dede_estado', 1)
        -> join('pedido p', 'p.pedi_id = dd.dede_pedi_id')
        -> get() -> getResultArray();
    }

    public function getPedido(){
        return $this -> db -> table('pedido p')
        -> where('p.pedi_estado', 1)
        -> get() -> getResultArray();
    }
}