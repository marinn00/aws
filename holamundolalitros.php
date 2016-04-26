<?php
require 'sem.php';

$name = $_GET['name'];
$carrera = $_GET['carrera'];

$alumnos = [
	'a1' => 'Lalitros',
	'a2' => 'Alambrito'
];

$alumno = $alumnos['a1'];

echo "Hola $name! y estoy estudiando $carrera con Terrazo! y estoy en $semestre semestre y estudio con $alumno";
?>