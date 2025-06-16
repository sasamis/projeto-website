<?php
include_once '../config/Config.php';

/*

DAO (Data Access Object) é um padrão de design (design pattern) utilizado 
para abstrair e encapsular o acesso a uma fonte de dados. Ele fornece uma 
interface para realizar operações CRUD (Create, Read, Update, Delete) na 
base de dados sem expor os detalhes de implementação ao restante 
do aplicativo.

*/

abstract Class DAO{

    /*
    
    Os métodos inserir, selecionar, atualizar e deletar são 
    declarados como métodos abstratos. Isso significa que 
    qualquer classe que herdar de DAO deve implementar esses 
    métodos. Cada um desses métodos aceita um parâmetro $dto 
    (Data Transfer Object),que normalmente encapsula os dados 
    a serem manipulados.
    
    */


    abstract protected function inserir($dto);
    abstract protected function selecionar($dto);
    abstract protected function atualizar($dto);
    abstract protected function deletar($dto);



    public function conectar() {
        $conexao = new mysqli(
            Config::$nomeDoServidor, 
            Config::$nomeDoUsuario, 
            Config::$senha, 
            Config::$nomeDoBancoDeDados
        );
        if ($conexao->connect_error)
            exit("Falha na conexão: ".$conexao->connect_error);
        else
            return $conexao;
    }



}