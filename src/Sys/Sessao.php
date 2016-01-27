<?php

namespace Sys;

class Sessao
{
	public function __construct() {
		
		if (!isset($_SESSION))
			session_start();
	}
	
	/**
	 * @param string $nome
	 * @return boolean
	 */
	public function existe($nome) {
		
		return isset($_SESSION[$nome]);
	}
	
	/**
	 * @param string $nome
	 * @param mixed $valor
	 * @return void
	 */
	public function gravar($nome, $valor) {
		
		$_SESSION[$nome] = $valor;
	}
	
	/**
	 * @param string $nome
	 * @return mixed
	 */
	public function ler($nome) {
		
		if ($this->existe($nome))
			return $_SESSION[$nome];
		
		return null;
	}
	
	/**
	 * @param string $nome
	 * @return void
	 */
	public function excluir($nome) {
		
		if ($this->existe($nome))
			unset($_SESSION[$nome]);
	}
	
	/**
	 * @return boolean
	 */
	public function destruir() {
		
		if (isset($_SESSION))
			return session_destroy();
		
		return false;
	}
}
