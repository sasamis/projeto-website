<?php
include_once '../lib/LibUtil.php';
include_once '../model/DTO/Usuario.php';
include_once '../model/DTO/Pessoa.php';
include_once '../model/DAO/UsuarioDAO.php';
include_once '../model/DAO/PessoaDAO.php';



Class Controller {

    
    #============================================# ANIMAÇÕES #=====================================================#

    public function atrasarRedirecionarIndex() {
        LibUtil::atrasar(2);
        LibUtil::redirecionar('login.php');
    }



    public function atrasarRedirecionarInicio() {
        LibUtil::atrasar(2);
        LibUtil::redirecionar('inicio.php');
    }

    
    #============================================# PERFIL #=====================================================#

    public function cadastrarPerfil() {

        if (isset($_POST['botao_enviar'])) {
            // Verifica se o formulário foi submetido
            
            // Extrai os dados do formulário
            extract($_POST);
        
            // Verifica se a senha tem pelo menos 8 caracteres e o usuário tem pelo menos 3 caracteres
            if (strlen($senha) < 8 || strlen($login) < 3) {
                // Exibe uma mensagem de erro
                echo "<script>alert('A senha deve ter pelo menos 8 caracteres e o usuário deve ter pelo menos 3 caracteres.');</script>";
                return;
            }
        
            // Cria um novo objeto de usuário com o login e a senha fornecidos
            // A senha é criptografada usando password_hash antes de ser armazenada no banco de dados
            $usuario = new Usuario(
                login: $login, 
                senha: password_hash($senha, PASSWORD_DEFAULT));
        
            // Insere o novo usuário no banco de dados e obtém o ID do usuário inserido
            $idUsuario = (new UsuarioDAO)->inserir($usuario);
        
            // Cria um novo objeto de pessoa associado ao ID do usuário recém-inserido
            $pessoa = new Pessoa(
                idUsuario: $idUsuario, 
                nome: $nome, 
                email: $email, 
                fone: $fone, 
                sexo: $sexo, 
                nascimento: $nascimento, 
                estado: $estado, 
                semestre: $semestre, 
                descricao: $descricao
            );
        
            // Insere os dados da pessoa no banco de dados
            if ((new PessoaDAO)->inserir($pessoa)) {
                // Se a inserção for bem-sucedida, inicia uma sessão
                LibUtil::comecarSessao();
                
                // Define $_SESSION['Transicao'] como verdadeiro (possivelmente para fins de controle de fluxo)
                // $_SESSION['Transicao'] = true; #SEGURANÇA
                
                // Redireciona para a página de sucesso de cadastro
                LibUtil::redirecionar('cadastroSucesso.php');
            }
        }
        
    }

    public function consultarPerfil() {
        LibUtil::comecarSessao();
        $pessoa = new Pessoa(idUsuario: $_SESSION['idUsuario']);
        return (new PessoaDAO())->selecionar($pessoa);
    }

    public function excluirPerfil() {
        // Verifica se o formulário foi submetido
        if (isset($_POST['botao_enviar'])) {
            // Inicia a sessão
            LibUtil::comecarSessao();
    
            // Cria um novo objeto de usuário com o ID do usuário atual
            $usuario = new Usuario(
                idUsuario: $_SESSION['idUsuario']);
    
            // Cria um novo objeto de pessoa com o ID do usuário atual
            $pessoa = new Pessoa(
                idUsuario: $_SESSION['idUsuario']);
    
            // Verifica se a exclusão do usuário e da pessoa foram bem-sucedidas no banco de dados
            if ((new UsuarioDAO())->deletar($usuario) && (new PessoaDAO())->deletar($pessoa)) {
                // Define $_SESSION['Transicao'] como verdadeiro (possivelmente para fins de controle de fluxo)
                // $_SESSION['Transicao'] = true; #SEGURANÇA
                
                // Redireciona para a página de exclusão bem-sucedida
                LibUtil::redirecionar('exclusaoSucesso.php');
            }
        }
    }
    

    public function sairPerfil(){
        LibUtil::comecarSessao();
        $_SESSION = array();
        LibUtil::atrasar(2);
        LibUtil::redirecionar('login.php');
    }
    

    public function editarPerfil() {
        // Verifica se o formulário foi submetido
        if (isset($_POST['botao_enviar'])) {
            // Extrai os dados do formulário
            extract($_POST);
    
            // Cria um novo objeto de usuário com o ID do usuário atual e a senha fornecida (já criptografada)
            $usuario = new Usuario (
                idUsuario: $_SESSION['idUsuario'], 
                senha: password_hash($senha, PASSWORD_DEFAULT));
    
            // Cria um novo objeto de pessoa com os dados fornecidos no formulário e o ID do usuário atual
            $pessoa = new Pessoa (
                idUsuario: $_SESSION['idUsuario'], 
                nome: $nome, 
                email: $email, 
                fone: $fone, 
                sexo: $sexo, 
                nascimento: $nascimento, 
                estado: $estado, 
                semestre: $semestre, 
                descricao: $descricao
            );
    
            // Verifica se as atualizações foram bem-sucedidas no banco de dados
            if ((new UsuarioDAO)->atualizar($usuario) && (new PessoaDAO)->atualizar($pessoa)) {
                // Se as atualizações foram bem-sucedidas, redireciona para a página de consulta do perfil
                LibUtil::redirecionar('consulta.php');
            }
        }
    }
    

    #============================================# VALIDAÇÕES #=====================================================#
    public function autenticarCredenciais() {
        // Verifica se o formulário foi submetido
        if (isset($_POST['botao_enviar'])) {
            // Extrai os dados do formulário
            extract($_POST);
    
            // Cria um objeto de usuário com o login fornecido
            $usuario = new Usuario(login: $login);
    
            // Consulta o banco de dados para obter os dados do usuário com base no login fornecido
            $vetorDadosUsuario = (new UsuarioDAO)->selecionar($usuario);
    
            // Verifica se foram encontrados dados do usuário com base no login
            if ($vetorDadosUsuario) {
                // Verifica se a senha fornecida corresponde à senha armazenada no banco de dados
                if (password_verify($senha, $vetorDadosUsuario['senha'])) {
                    // Inicia a sessão
                    LibUtil::comecarSessao();
                    
                    // Define o ID do usuário na sessão e marca a transição como verdadeira
                    $_SESSION['idUsuario'] = $vetorDadosUsuario['idUsuario'];
                    // $_SESSION['Transicao'] = true; #SEGURANÇA
                    
                    // Redireciona para a página de sucesso de login
                    LibUtil::redirecionar('loginSucesso.php');
                }
            }
            // Se as credenciais estiverem incorretas ou o usuário não existir, exibe uma mensagem de erro
            echo "<script>alert('Senha e/ou login errados ou o usuário não existe.');</script>";
        }
    }
    

    public function validarToken() {
        // Verifica se o formulário foi submetido
        if (isset($_POST['botao_enviar'])) {
            // Inicia a sessão
            LibUtil::comecarSessao();
    
            // Verifica se o token de sessão e o token enviado no formulário são iguais
            if (!(isset($_SESSION['token']) && $_SESSION['token'] == $_POST['token'])) {
                // Se os tokens não forem iguais, retorna um cabeçalho indicando o erro 405 Method Not Allowed
                header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
    
                // Exibe uma mensagem de erro usando JavaScript
                echo '<script>alert("405 Método não permitido.")</script>';
    
                // Redireciona o usuário para a página de login
                LibUtil::redirecionar('login.php');
            }
        }
    }
    
    
    #============================================# SEGURANÇA #=====================================================#

    /*
    A função gerarToken é usada para criar um token único, que pode ser usado para prevenir ataques 
    Cross-Site Request Forgery (CSRF). Este tipo de ataque ocorre quando um atacante faz com que o 
    navegador de um usuário autenticado execute uma ação indesejada em um aplicativo no qual ele está 
    autenticado.
    */

    public function gerarToken() {
        LibUtil::comecarSessao();
        /* Gera um token único e aleatório usando a combinação de uniqid e mt_rand, então aplica md5 para criar um hash.
         - > uniqid: Gera um ID único baseado no timestamp atual.
         - > mt_rand: Gera um número inteiro aleatório.
         - > md5: Calcula o hash MD5 de da string gerado por uniqid() e mt_rand().
        */
        $_SESSION['token'] = md5(uniqid(mt_rand(), true));

        /* 
        Insere o token gerado em um campo oculto de um formulário HTML.
        Isso permite que o token seja enviado junto com o formulário 
        quando ele for submetido. 
        */
        echo "<input name='token' value='".$_SESSION['token']."' type= 'hidden'>";
    }

    /*
    Verifica se existe uma variável chamada idUsuario 
    na sessão atual. Se existir, significa que o usuário 
    já está logado, pois normalmente o ID do usuário é 
    armazenado na sessão após o login.
    */

    public function restringirAcessoUsuario() {
        LibUtil::comecarSessao();
        if (isset($_SESSION['idUsuario']))
            LibUtil::redirecionar('inicio.php');
    }
        

    /*
    A função abaixo usada para impedir que usuários não logados
    acessem determinadas partes do site, redirecionando-os para 
    a página de login. Ou seja, senão existe o id do usuário, significa
    que o usuário não está logado, então ele é redirecionado para a página de
    login
    */
    public function restringirAcessoVisitante() {
        LibUtil::comecarSessao();
        if (! isset($_SESSION['idUsuario'])) 
            LibUtil::redirecionar('login.php');
    }

    /*

    A função abaixo usada para impedir que usuários acesse uma página sem antes
    ter passado pela página de login. Ou seja, se a variável de sessão 'Transicao'
    não existir, o usuário é redirecionado para a página de login.
    */

    // public function restringirAcessoTransicao() {
    //     LibUtil::comecarSessao();
    //     if (! isset($_SESSION['Transicao'])) 
    //         LibUtil::redirecionar('login.php');
    //     else
    //         unset($_SESSION['Transicao']);
    // }
            
    

}    

