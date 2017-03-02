<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class TurbinasTable extends Table
{

	public function initialize(array $config)
    {
        $this->primaryKey('id');
        $this->table('turbinas');
    }
	/*
	private $ID = "null";
	private $Posicion;
	private $Capacidad;
	private $Temperatura;
	private $Instalacion;
	private $Mantenimiento;

	public function setID(int $ID)
	{
		$this->ID = $ID;
	}

	public function setPosicion(int $Posicion)
	{
		$this->Posicion = $Posicion;
	}

	public function setCapacidad(int $Capacidad)
	{
		$this->Capacidad = $Capacidad;
	}

	public function setTemperatura(int $Temperatura)
	{
		$this->Temperatura = $Temperatura;
	}

	public function setInstalacion(String $Instalacion)
	{
		$this->Instalacion = $Instalacion;
	}

	public function setMantenimiento(String $Mantenimiento)
	{
		$this->Mantenimiento = $Mantenimiento;
	}
	*/
}

?>
