<?php


namespace App\Models;


use CodeIgniter\Model;

class Work extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'work';

    protected $allowedFields    = ['id', 'created_at', 'finish_at', 'observation', 'document', 'documento_id_documento', 'users_id', 'user_aux', 'work_type_id', 'status'];

    public function User($id){
        $user = $this->builder('users')->where(['id'=>$id])->get()->getResult();
        $rol = $this->builder('roles')->where(['id'=>$user[0]->role_id])->get()->getResult();
        $user[0]->rol = $rol[0];
        return $user[0];
    }

    public function Documento($id){
        
        return $this->builder('documento')->where(['id_documento'=>$id])->join('documento_tipo', 'documento.id_tipo = documento_tipo.id_tipo')->get()->getFirstRow();
    }

}