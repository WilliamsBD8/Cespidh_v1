<?php


namespace App\Controllers;

use App\Models\Formularios;
use App\Models\User;
use Config\Services;


class CiudadanoController extends BaseController
{
    public function index(){
        $modelo = new Formularios();
        $formularios = $modelo->findAll(); 
        
        return view('ciudadano/ciudadanos' , ['formularios'=>$formularios]);         
    }


}