<?php

namespace Sys;

class Usuario
{
	const ATIVO = 1;
	const INVATIVO = 0;

	/**
	 * @var Conexao
	 */
	private $con;

	/**
	 * @param Conexao $con
	 */
	public function __construct($con) {

		$this->con = $con;
	}

	/**
	 * @param string $email
	 * @param string $senha
	 * @return object
	 * @throws ValidacaoException
	 */
	public function validar($email, $senha) {

		if (empty($email) || empty($senha))
			throw new ValidacaoException('Preencha o login e senha');

		$rs = $this->con->selecionar(
			'SELECT * FROM usuarios WHERE email = ? AND senha = ? AND ativo = ? LIMIT 1',
			array($email, $senha, self::ATIVO)
		);

		if (count($rs) < 1)
			throw new ValidacaoException('Login ou senha inválida');

		return $rs[0];
	}
}
