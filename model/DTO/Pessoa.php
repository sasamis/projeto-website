<?php

/*
DTO, ou Data Transfer Object, é um padrão de design 
usado para transferir dados entre diferentes partes 
de uma aplicação. Ele é um objeto simples que não 
contém lógica de negócios, apenas propriedades para 
transportar dados.

Transportar dados, neste contexto, refere-se ao processo 
de mover informações estruturadas entre diferentes partes 
da aplicação para realizar operações de entrada, processamento 
e armazenamento de dados de forma eficiente e segura. 
O uso de DTOs (Data Transfer Objects) é uma prática comum e 
recomendada para facilitar esse transporte de dados, garantindo 
que o código seja mais organizado, desacoplado e fácil de manter.
*/

Class Pessoa{

    /*
    
    Este construtor usa uma sintaxe 
    específica do PHP 8.0 chamada 
    "promoted properties". 
    Nessa sintaxe, as propriedades da 
    classe são declaradas e inicializadas 
    diretamente na assinatura do construtor. 
    Isso elimina a necessidade de declarar as 
    propriedades da classe separadamente e de 
    inicializá-las no corpo do construtor, tornando 
    o código mais conciso.
    
    */

    public function __construct(
        public $idPessoa = null, 
        public $idUsuario = null, 
        public $nome = null,
        public $email = null, 
        public $fone = null, 
        public $sexo = null,
        public $nascimento = null, 
        public $estado = null,
        public $semestre = null, 
        public $descricao = null
    ) {}



}