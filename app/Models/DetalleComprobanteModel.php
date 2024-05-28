<?php
namespace App\Models;
use CodeIgniter\Model;
class DetalleComprobanteModel extends Model{
    protected $table = 'detalle_comprobante';
    protected $primaryKey = 'deco_id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'deco_comp_id',
        'deco_prod_id',
        'deco_cantidad',
        'deco_subtotal',
        'deco_estado'
    ];

    public function getDetalleComprobante(){
        return $this -> db -> table('detalle_comprobante dc')
        -> where('dc.deco_estado', 1)
        -> join('comprobante c', 'c.comp_id = dc.deco_comp_id')
        -> join('producto pd', 'pd.prod_id = dc.deco_prod_id')
        -> get() -> getResultArray();
    }

    public function getId($id){
        return $this -> db -> table('detalle_comprobante dc')
        -> where('dc.deco_id', $id)
        -> where('dc.deco_estado', 1)
        -> join('comprobante c', 'c.comp_id = dc.deco_comp_id')
        -> join('producto pd', 'pd.prod_id = dc.deco_prod_id')
        -> get() -> getResultArray();
    }

    public function getComprobante(){
        return $this -> db -> table('comprobante c')
        -> where('c.comp_estado', 1)
        -> get() -> getResultArray();
    }
    public function getProducto(){
        return $this -> db -> table('producto pd')
        -> where('pd.prod_estado', 1)
        -> get() -> getResultArray();
    }
}