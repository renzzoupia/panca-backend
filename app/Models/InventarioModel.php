<?php
namespace App\Models;
use CodeIgniter\Model;
class InventarioModel extends Model{
    protected $table = 'inventario';
    protected $primaryKey = 'inv_id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'prod_id',
        'prov_id',
        'inv_tipo_movimiento',
        'inv_cantidad',
        'inv_fecha_ing',
        'inv_fecha_vencimiento',
        'inv_estado'
    ];
    //Como es una tabla relacionada con llaves foraneas vamos a crear
    //las relaciones en el modelo

    public function getInventario(){
        return $this -> db -> table('inventario i')
        -> where('i.inv_estado', 1)
        -> join('proveedores pv', 'i.prov_id = pv.prov_id')
        -> join('productos pd', 'i.prod_id = pd.prod_id')
        -> get() -> getResultArray();
    }

    public function getId($id){
        return $this -> db -> table('inventario i')
        -> where('i.inv_id', $id)
        -> where('i.inv_estado', 1)
        -> join('proveedores pv', 'i.prov_id = pv.prov_id')
        -> join('productos pd', 'i.prod_id = pd.prod_id')
        -> get() -> getResultArray();
    }

    public function getProveedores(){
        return $this -> db -> table('proveedores pv')
        -> where('pv.prov_estado', 1)
        -> get() -> getResultArray();
    }

    public function getProductos(){
        return $this -> db -> table('productos pd')
        -> where('pd.prod_estado', 1)
        -> get() -> getResultArray();
    }
}