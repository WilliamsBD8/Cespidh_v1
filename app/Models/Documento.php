<?php


namespace App\Models;


use CodeIgniter\Model;

class Documento extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'documento';

    protected $allowedFields    = ['id_documento', 'id_tipo', 'id_estado', 'users_id', 'fecha', 'help'];

}