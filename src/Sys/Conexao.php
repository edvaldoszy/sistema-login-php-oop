<?php

namespace Sys;

class Conexao {

	private static $pdo;

	/**
	*@param string $servidor 
	*@param string $banco 
	*@param string $usuario 
	*@param string $senha 
	*/

	public function __construct($servidor, $banco, $usuario, $senha) {

		if (self::$pdo == null) {
			$dsn = "mysql:host={$servidor};dbname={$banco};charset=utf8";
			self::$pdo = new \PDO($dns, $usuario, $senha);
			self::$pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
		}
	}

	/**
	 * @param string $sql
	 * @param array $argumentos
	 * @return \PDOStatement
	 */
	public function preparar($sql, array $argumentos = array()) {

		$stmt = self::$pdo->prepare($sql);
		foreach ($argumentos as $c => $v)
			$stmt->bindValue(($c+1), $v);

		return $stmt;
	}

	/**
	 * @param string $sql
	 * @param array $argumentos
	 * @return array
	 */
	public function selecionar($sql, array $argumentos = array()) {

		$stmt = $this->preparar($sql, $argumentos);
		$stmt->execute();
		return $stmt->fetchAll();
	}

	/**
	 * @param string $sql
	 * @param array $argumentos
	 * @return boolean
	 */
	public function executar($sql, array $argumentos = array()) {
		$stmt = $this->preparar($sql, $argumentos);
		return $stmt->execute();
	}
}
