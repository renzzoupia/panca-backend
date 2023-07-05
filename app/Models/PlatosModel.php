<?php
namespace App\Models;
use CodeIgniter\Model;
class PlatosModel extends Model{
    protected $table = 'platos';
    protected $primaryKey = 'pla_id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'pla_comida',
        'pla_precio',
        'pla_descrip',
        'tico_id',
        'pla_estado'
    ];

    public function getPlatos(){
        return $this -> db -> table('platos p')
        -> where('p.pla_estado', 1)
        -> join('tipo_comida tc', 'p.tico_id = tc.tico_id')
        -> get() -> getResultArray();
    }

    public function getId($id){
        return $this -> db -> table('platos p')
        -> where('p.pla_id', $id)
        -> where('p.pla_estado', 1)
        -> join('tipo_comida tc', 'p.tico_id = tc.tico_id')
        -> get() -> getResultArray();
    }

    public function getTipoComida(){        
        return $this -> db -> table('tipo_comida tp')
        -> where('tp.tico_estado', 1)
        -> get() -> getResultArray();
    }
}