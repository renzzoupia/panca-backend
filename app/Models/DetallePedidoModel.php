<?php
namespace App\Models;
use CodeIgniter\Model;
class DetallePedidoModel extends Model{
    protected $table = 'detalle_pedido';
    protected $primaryKey = 'depe_id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'depe_pedi_id',
        'depe_prod_id',
        'depe_cantidad',
        'depe_subtotal',
        'depe_estado'
    ];

    public function getDetallePedido(){
        return $this -> db -> table('detalle_pedido dp')
        -> where('dp.depe_estado', 1)
        -> join('pedido p', 'p.pedi_id = dp.depe_pedi_id')
        -> join('producto pd', 'pd.prod_id = dp.depe_prod_id')
        -> get() -> getResultArray();
    }

    public function getId($id){
        return $this -> db -> table('detalle_pedido dp')
        -> where('dp.depe_id', $id)
        -> where('dp.depe_estado', 1)
        -> join('pedido p', 'p.pedi_id = dp.depe_pedi_id')
        -> join('producto pd', 'pd.prod_id = dp.depe_prod_id')
        -> get() -> getResultArray();
    }

    public function getPedido(){
        return $this -> db -> table('pedido p')
        -> where('p.pedi_estado', 1)
        -> get() -> getResultArray();
    }
    public function getProducto(){
        return $this -> db -> table('producto pd')
        -> where('pd.prod_estado', 1)
        -> get() -> getResultArray();
    }
}