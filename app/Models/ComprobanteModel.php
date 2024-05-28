<?php
namespace App\Models;
use CodeIgniter\Model;
class ComprobanteModel extends Model{
    protected $table = 'comprobante';
    protected $primaryKey = 'comp_id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'comp_rest_id',
        'comp_clie_id',
        'comp_pedi_id',
        'comp_serie',
        'comp_fecha',
        'comp_subtotal',
        'comp_igv',
        'comp_total',
        'comp_estado'
    ];

    public function getComprobante(){
        return $this -> db -> table('comprobante c')
        -> where('c.comp_estado', 1)
        -> join('restaurante r', 'r.rest_id = c.comp_rest_id')
        -> join('cliente cl', 'cl.clie_id = c.comp_clie_id')
        -> get() -> getResultArray();
    }

    public function getId($id){
        return $this -> db -> table('comprobante c')
        -> where('c.comp_id', $id)
        -> where('c.comp_estado', 1)
        -> join('restaurante r', 'r.rest_id = c.comp_rest_id')
        -> join('cliente cl', 'cl.clie_id = c.comp_clie_id')
        -> get() -> getResultArray();
    }

    public function getRestaurante(){
        return $this -> db -> table('restaurante r')
        -> where('r.rest_estado', 1)
        -> get() -> getResultArray();
    }
    public function getCliente(){
        return $this -> db -> table('cliente cl')
        -> where('cl.clie_estado', 1)
        -> get() -> getResultArray();
    }
}