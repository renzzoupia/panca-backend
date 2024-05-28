<?php
namespace App\Models;
use CodeIgniter\Model;
class PedidoModel extends Model{
    protected $table = 'pedido';
    protected $primaryKey = 'pedi_id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'pedi_mesa_id',
        'pedi_clie_id',
        'pedi_tipo_pedido',
        'pedi_fecha',
        'pedi_total',
        'pedi_estado'
    ];

    public function getPedido(){
        return $this -> db -> table('pedido p')
        -> where('p.pedi_estado', 1)
        -> join('mesa m', 'm.mesa_id = p.pedi_mesa_id')
        -> join('cliente c', 'c.clie_id = p.pedi_clie_id')
        -> get() -> getResultArray();
    }

    public function getId($id){
        return $this -> db -> table('pedido p')
        -> where('p.pedi_id', $id)
        -> where('p.pedi_estado', 1)
        -> join('mesa m', 'm.mesa_id = p.pedi_mesa_id')
        -> join('cliente c', 'c.clie_id = p.pedi_clie_id')
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
}