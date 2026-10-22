<?php

namespace app\models;

use \DataBase;
use \Model;

class UserModel extends Model
{
	protected $table = "usuarios";
	protected $primaryKey = "id_usuario";
	protected $secundaryKey = "email";
	public $email;

	public static function getAllUsers()
	{
		$model = new static();
		$sql = "SELECT * FROM usuarios";
		$result = DataBase::query($sql);

		return $result;
	}

	public static function findEmail($email)
	{
		$model = new static();
		$sql = "SELECT * FROM {$model->table} WHERE {$model->secundaryKey} = :email";
		$params = ["email" => $email];
		$result = DataBase::getRecord($sql, $params);
		return $result;
	}

	public static function getUserByEmail($email)
	{
		$model = new static();
		$sql = "SELECT * FROM " . $model->table . " WHERE email = '$email'";
		$result = DataBase::query($sql);

		return $result;
	}

	public static function login($email, $password)
	{
	    $sql = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";
	    $params = [':email' => $email];
	    
	    $result = DataBase::query($sql, $params);

	    $usuario = is_array($result) && isset($result[0]) ? $result[0] : $result;

	    if ($usuario && password_verify($password, $usuario->password)) {
	        return $usuario;
	    }

	    return false;
	}

	public static function registrar($nombre, $email, $password, $direccion, $telefono) 
	{
	    // Hashear la contraseña antes de guardarla
	    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

	    // 1. Verificar si el correo ya existe usando tu wrapper
	    $sqlCheck = "SELECT id FROM usuarios WHERE email = :email LIMIT 1";
	    $paramsCheck = [':email' => $email];
	    $resultCheck = DataBase::query($sqlCheck, $paramsCheck);

	    // Si devuelve resultados, significa que el email ya está registrado
	    $existe = is_array($resultCheck) && isset($resultCheck[0]) ? $resultCheck[0] : $resultCheck;
	    if ($existe) {
	        return false; // El correo ya existe
	    }

	    // 2. Insertar el nuevo usuario usando DataBase::execute
	    $sqlInsert = "INSERT INTO usuarios (nombre, email, password, direccion, telefono, rol) 
	                  VALUES (:nombre, :email, :password, :direccion, :telefono, 'cliente')";
	    
	    $paramsInsert = [
	        ':nombre'    => $nombre,
	        ':email'     => $email,
	        ':password'  => $passwordHash,
	        ':direccion' => $direccion,
	        ':telefono'  => $telefono
	    ];

	    return DataBase::execute($sqlInsert, $paramsInsert);
	}
	

}
