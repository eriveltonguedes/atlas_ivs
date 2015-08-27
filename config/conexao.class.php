<?php

/**
 * Conexão Banco de dados.
 * 
 * @author AtlasBrasil
 */
class Conexao
{
    /**
     * Host.
     * 
     * @var string 
     */
    protected $host = 'localhost';
    
    /**
     * Usuário.
     * 
     * @var string 
     */
    protected $user = '';
    
    /**
     * Porta.
     * 
     * @var string 
     */
    protected $port = '5432';
    
    /**
     * Senha.
     * 
     * @var string 
     */
    protected $pswd = '';
    
    /**
     * Nome do Banco de dados.
     * 
     * @var string 
     */

    protected $dbname = '';
    
    /**
     * Conexao com banco de dados.
     * 
     * @var resource 
     */

    protected $con = null;

    /**
     * Método construtor
     */
    public function __construct()
    {
        // $this->open();
    }

    /**
     * Abre conexão com banco de dados.
     * 
     * @return resource
     */
    public function open()
    {
        $this->con = pg_connect("host=$this->host port=$this->port user=$this->user password=$this->pswd dbname=$this->dbname");

        if (!$this->con) {
            echo "Failed connecting to postgres database\n";
            exit();
        }

        return $this->con;
    }

    /**
     * Encerra a conexao.
     * 
     */
    public function close()
    {
        @pg_close($this->con);
    }

    /**
     * Retorna o nome do Host.
     * 
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * Retorna o nome de Usuário de Acesso ao Banco de Dados.
     * 
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Retorna o nome de Usuário de Acesso ao Banco de Dados.
     * 
     * @return string
     */
    public function getPassword()
    {
        return $this->pswd;
    }

    /**
     * Retorna o nome do Banco de Dados.
     * 
     * @return type
     */
    public function getNameBd()
    {
        return $this->dbname;
    }

    /**
     * Recupera a porta de conexão ao Banco de Dados.
     * 
     * @return string
     */
    public function getPort()
    {
        return $this->port;
    }

}
