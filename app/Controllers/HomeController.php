<?php

namespace App\Controllers;


use App\Models\User;
use App\Models\Documento;
use App\Models\TiposDocumento;


class HomeController extends BaseController
{

	public function index()
	{
		$user = new User();
		$documento = new TiposDocumento();
		$user = $user->where(['role_id' => 6])->get()->getResult();
		$date = strtotime(date('Y-m-d'));
		$meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
		$meses_aux = [];
		$documentos_aux = [];
		$tipo_aux = [];
		for ($i=0;$i<6;$i++){
			$mes = $meses[(date('n', mktime(0, 0, 0, (date("n")-$i), 1, date("Y") ) ))-1];
			$inicia = (date('Y-m-01', mktime(0, 0, 0, (date("n")-$i), 1, date("Y") ) )).' 00:00:00';
			$termina = (date('Y-m-t', mktime(0, 0, 0, (date("n")-$i), 1, date("Y") ) )). ' 23:59:59';
			array_push($meses_aux, $mes);
			$documentos = $documento
			->select('documento_tipo.*,
				(select count(documento.id_documento) from documento where (documento.id_tipo = documento_tipo.id_tipo)) AS total,
				(select count(documento.id_documento) from documento where (documento.id_tipo = documento_tipo.id_tipo and fecha BETWEEN "'.$inicia.'" AND "'.$termina.'" )) AS total_mes
				')
				->get()->getResult();
				array_push($documentos_aux, $documentos);
			if($i == 0)
			$card = $documentos;
		}
		foreach ($documentos_aux as $key => $documento) {
			foreach($documento as $key => $value){
				$tipo_aux[$value->descripcion] = $value->descripcion;
			}
		}
		$tipos = [];
		$i = 0;
		foreach ($tipo_aux as $llave => $tipo) {
			$aux_algo = [];
			foreach ($documentos_aux as $key => $documento) {
				foreach($documento as $key => $value){
					if($value->descripcion == $tipo){
						array_push($aux_algo, $value->total_mes);
					}
				}
			}
			$tipos[$i]['name'] = $tipo;
			$tipos[$i]['totales'] = $aux_algo;
			$aux_algo = [];
			$i++;
		}
		// return var_dump($tipos);

		$documentos = new Documento();
		$genero = $documentos
		->select('genero.name as genero, count(documento.id_documento) as total')
		->join('users', 'documento.users_id = users.id')
		->join('genero', 'users.genero_id = genero.id')
		->groupBy('genero.name')
		->get()->getResult();

		$etnia = $documentos
		->select('grupo_etnia.name as grupo_etnia, count(documento.id_documento) as total')
		->join('users', 'documento.users_id = users.id')
		->join('grupo_etnia', 'users.grupo_etnia_id = grupo_etnia.id')
		->groupBy('grupo_etnia.name')
		->get()->getResult();
		
		return  view('pages/home',
		['user' => $user, 'documentos_tipo' => $documentos_aux[0], 'documentos' => $tipos, 'meses' => $meses_aux,
		'genero' => $genero, 'grupos' => $etnia
		]);
	}

	public function about()
    {
        return view('pages/about');
    }

}
