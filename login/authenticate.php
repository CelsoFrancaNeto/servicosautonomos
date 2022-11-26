<?php
include "configDB/connect.php";

$erroEmail = "";
$erroSenha = "";
$errorUserNotFound = "";

if (isset($_POST['email']) || isset($_POST['senha'])) {

    if (strlen($_POST['email']) != 0 && strlen($_POST['senha']) != 0) {
        $email = $conn->real_escape_string($_POST['email']);
        $senha = $conn->real_escape_string($_POST['senha']);

        $sql_code = "SELECT * FROM usuario WHERE email = '$email' AND senha = '$senha'";
        $sql_query = $conn->query($sql_code) or die("Falha na execução do código SQL: " . $conn->error);

        $quantidade = $sql_query->num_rows;

        if ($quantidade == 1) {
            $usuario = $sql_query->fetch_assoc();

            if (!isset($_SESSION)) {
                session_start();
            }

            $_SESSION['user'] = $usuario['CPF'];
            $_SESSION['name'] = $usuario['Nome'];

            header("Location: view/painel.php");
        } else {
            $errorUserNotFound = "E-mail ou senha inválidos";
        }
    } else {

        if (strlen($_POST['email']) == 0) {
            $erroEmail = "Favor inserir o seu endereço de e-mail";
        }
        if (strlen($_POST['senha']) == 0) {
            $erroSenha = "Favor inserir a sua senha";
        }
    }
}

$erroName = "";
$erroCPF = "";
$erroEmailRegistro = "";
$erroTelefone = "";
$erroConfirmarSenha = "";

if (isset($_POST['envio-registro'])) {
    if (strlen($_POST["nome"]) == 0) {
        $erroName = "Favor inserir o seu nome";
    }

    if (strlen($_POST["cpf"]) == 0) {
        $erroCPF = "Favor inserir o seu CPF";
    }

    if (strlen($_POST["email-registro"]) == 0) {
        $erroEmailRegistro = "Favor inserir o seu e-mail";
    }

    if (strlen($_POST["senha-registro"]) == 0 && strlen($_POST["confirmar-senha"]) == 0) {
        $erroConfirmarSenha = "Favor criar a sua senha";
    } else if (strlen($_POST["senha-registro"]) != strlen($_POST["confirmar-senha"])) {
        $erroConfirmarSenha = "As senhas não coincidem";
    }

    if (strlen($_POST["telefone"]) == 0) {
        $erroTelefone = "Favor inserir o seu telefone";
    }

    if (
        strlen($_POST["nome"]) != 0 &&
        strlen($_POST["cpf"]) != 0 &&
        strlen($_POST["email-registro"]) != 0 &&
        strlen($_POST["senha-registro"]) != 0 &&
        strlen($_POST["confirmar-senha"]) != 0 &&
        strlen($_POST["telefone"]) != 0
    ) {
        if (validaCPF(($_POST["cpf"]))) {
            if (validaEmail($_POST["email-registro"])) {
                if ($_POST["senha-registro"] == $_POST["confirmar-senha"]) {
                    $nome = $conn->real_escape_string($_POST['nome']);
                    $cpf = $conn->real_escape_string( limpaCPF_CNPJ($_POST['cpf']));
                    $email = $conn->real_escape_string($_POST['email-registro']);
                    $senha = $conn->real_escape_string($_POST['senha-registro']);
                    $telefone = $conn->real_escape_string($_POST['telefone']);
                    
                    try {

                        $sql_code = "INSERT INTO usuario VALUES ('$cpf','$nome','$telefone','$email','$senha')";
                        $sql_query = $conn->query($sql_code) or die("Falha na execução do código SQL: " . $conn->error);
                    } catch (mysqli_sql_exception $error) {
                        echo $error;
                    }
                }
            }
        }
    }
}


function validaCPF($cpf)
{
    // Link do criador da função: https://gist.github.com/rafael-neri/ab3e58803a08cb4def059fce4e3c0e40

    // Extrai somente os números
    $cpf = preg_replace('/[^0-9]/is', '', $cpf);

    // Verifica se foi informado todos os digitos corretamente
    if (strlen($cpf) != 11) {
        return false;
    }

    // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
    if (preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }

    // Faz o calculo para validar o CPF
    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            return false;
        }
    }
    return true;
}

function limpaCPF_CNPJ($valor){
    $valor = trim($valor);
    $valor = str_replace(".", "", $valor);
    $valor = str_replace(",", "", $valor);
    $valor = str_replace("-", "", $valor);
    $valor = str_replace("/", "", $valor);
    return $valor;
}

function validaEmail($email)
{
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    } else {
        return false;
    }
}
