<?php


namespace App\Models;


use CodeIgniter\Model;

class User extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['name', 'username', 'email', 'password', 'status', 'role_id', 'photo', 'id', 'ciudad', 'direccion', 'genero_id', 'grupo_etnia_id', 'created_at'];

}