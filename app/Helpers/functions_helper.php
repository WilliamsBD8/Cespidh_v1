<?php

function date_fecha($date){
  $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
  $dias = ["Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado"];
  $date = strtotime($date);
  $date = $dias[date('w', $date)].' '.date('d', $date).' de '.$meses[(date("m", $date)-1)].' del '.date("Y", $date);
  return $date;
}

function fecha_aleatoria($formato = "Y/m/d", $limiteInferior = "2010-01-01", $limiteSuperior = "2022-12-31"){
  // Convertimos la fecha como cadena a milisegundos
  $milisegundosLimiteInferior = strtotime($limiteInferior);
  $milisegundosLimiteSuperior = strtotime($limiteSuperior);

  // Buscamos un número aleatorio entre esas dos fechas
  $milisegundosAleatorios = mt_rand($milisegundosLimiteInferior, $milisegundosLimiteSuperior);

  // Regresamos la fecha con el formato especificado y los milisegundos aleatorios
    return date($formato, $milisegundosAleatorios);
}


function documents(){
  $type_document = ['Derecho de Petición', 'Acción de Tutela', 'Denuncia General', 'Denuncia corrupción'];
  $names = ['Oscar', 'Andres', 'Martha', 'Susana', 'Carolina', 'Maicon'];
  $lastnames = ['Gonzales', 'Silva', 'Gutierrez', 'Diaz', 'Duarte'];
  $entidades = ['Santa Maria (H)', 'La Argentina (H)', 'Neiva (H)', 'Pitalito (H)', 'San Agustin (H)'];
  $status = ['En proceso', 'Rechazada', 'Finalizada'];
  $documents = [];
  for ($i=1; $i <= 13 ; $i++) {

    $ramdon = $type_document[rand(0, 3)];
    $document = [
      'id' => 'A'.$i,
      'name' => $names[rand(0, 5)].' '.$lastnames[rand(0, 4)],
      'cedula' => rand(10000, 50000),
      'document' => $type_document[rand(0, 3)],
      'status' => $status[rand(0,2)],
      'entidad' => $entidades[rand(0, 4)],
      'colaborador' => rand(0,1),
      'date' => fecha_aleatoria()
    ];
    array_push($documents, $document);
  }
  return $documents;
}

function ordinal($key){
  $numeros = [
    'PRIMERO',
    'SEGUNDO',
    'TERCERO',
    'CUARTO',
    'QUINTO',
    'SEXTO',
    'SÉPTIMO',
    'OCTAVO',
    'NOVENO',
    'DÉCIMO',
    'DÉCIMO PRIMERO',
    'DÉCIMO SEGUNDO',
    'DÉCIMO TERCERO',
    'DÉCIMO CUARTO',
    'DÉCIMO QUINTO',
    'DÉCIMO SEXTO',
    'DÉCIMO SÉPTIMO',
    'DÉCIMO OCTAVO',
    'DÉCIMO NOVENO',
    'VIGÉSIMO'
  ];

  return  $numeros[$key];
}