<?php


namespace App\Models;


use CodeIgniter\Model;

class Work extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'work';

    protected $allowedFields    = ['id', 'created_at', 'observation', 'document', 'documento_id_documento', 'users_id', 'work_type_id'];

    public function User($id){
        $user = $this->builder('users')->where(['id'=>$id])->get()->getResult();
        $rol = $this->builder('roles')->where(['id'=>$user[0]->role_id])->get()->getResult();
        $user[0]->rol = $rol[0];
        return $user[0];
    }

}