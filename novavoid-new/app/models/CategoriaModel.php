<?php

namespace app\models;

use \DataBase;
use \Model;

class CategoriaModel extends Model
{
	protected $table = "categorias";
	protected $primaryKey = "id";


	public static function obtenerTodasCategorias() {
        $model = new static();

        /*falta estado en bd*/
		$sql = "SELECT * FROM categorias";
		$result = DataBase::query($sql);

		return $result;
    }
}