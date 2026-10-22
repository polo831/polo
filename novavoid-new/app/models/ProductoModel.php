<?php

namespace app\models;

use \DataBase;
use \Model;

class ProductoModel extends Model
{
	protected $table = "productos";
	protected $primaryKey = "id";


	public static function obtenerTodos() {
        $model = new static();

        /*falta estado en bd*/
		$sql = "SELECT * FROM productos";
		$result = DataBase::query($sql);

		return $result;
    }

    public static function obtenerPorCategoria($id_categoria)
	{
		$model = new static();
		$sql = "SELECT * FROM productos WHERE categoria_id = :id_categoria";
		$params = [':id_categoria'   => $id_categoria];
		$result = DataBase::query($sql,$params);

		return $result;
	}

	public static function obtenerPorId($id)
	{
		$model = new static();
		$sql = "SELECT * FROM productos WHERE id = :id LIMIT 1";
		$params = [':id' => $id];
		$result = DataBase::query($sql,$params);

		return $result;
	}
}