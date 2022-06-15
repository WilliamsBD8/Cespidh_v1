<?php


namespace App\Models;


use CodeIgniter\Model;

class Documento extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'documento';

    protected $allowedFields    = ['id_documento', 'id_tipo', 'id_estado', 'users_id', 'fecha', 'help', 'sedes_id', 'terminos', 'firma'];

    public function Asignar($id){
        $user = $this->builder('work')
            ->select('users.name')
            ->join('users', 'work.user_aux = users.id')
            ->where(["documento_id_documento" => $id, "work.status" => "Pendiente"])->get()->getFirstRow();
        return $user->name; 
    }
}