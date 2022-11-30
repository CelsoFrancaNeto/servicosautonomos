<?php
include "../configDB/connect.php";
include "../login/protect.php";

$sql_code_all_services = "SELECT Nome FROM Tipo_Servico GROUP BY nome";
$sql_code_all_professions = "SELECT * FROM Profissao";
$error_mensage = "";
try {
    $sql_query =  $conn->query($sql_code_all_services) or die("Falha na execusão do código SQL: " . $conn->error);
    $sql_query_all_professions = $conn->query($sql_code_all_professions) or die("Falha na execusão do código SQL: " . $conn->error);
} catch (mysqli_sql_exception $error) {
    echo $error;
}

if (isset($_POST['enviarTipoServ'])) {
    $profissoes =  $_POST['profissaoAddTipoServico'];
    $nome =  utf8_decode($_POST['nomeAddTipoServico']);
    $descricao =  utf8_decode($_POST['descricaoAddTipoServico']);

    for ($i = 0; $i < sizeof($profissoes); $i++) {
        $sql_add_tipo_serv = "INSERT INTO tipo_servico (Nome,Descricao,ID_Profissao)
        VALUES ('$nome','$descricao',$profissoes[$i])";
        try {
            $sql_query_insert_tipo_serv = $conn->query($sql_add_tipo_serv) or die("Falha na execusão do código SQL: " . $conn->error);
            header("Refresh: 0");
            $error_mensage = "Tipo de Serviço criado com sucesso!";
        } catch (mysqli_sql_exception $error) {
            echo $error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="PT-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv=”Content-Type” content=”text/html; charset=utf-8″>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Painel</title>


    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integridade="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXmonymous" crossorigin="anonymous">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css">




    <link rel="stylesheet" href="../public/style-painel.css" type="text/css">

</head>

<body>
    <header>
        <nav class="navbar navbar-expand-md bg-dark navbar-dark">
            <p class="navbar-brand">Bem vindo, <?php echo utf8_encode($_SESSION['name']) ?></p>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="painel.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Perfil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Criar Serviço</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="services-progress.php">Serviços resposabilidade</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="my-services.php">Meus serviços</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../login/logout.php">Sair</a>
                    </li>
                </ul>
            </div>

        </nav>

    </header>

    <main>


        <div class="container">


            <form>
                <div class="error-mensage">
                    <label for=""><?php echo $error_mensage ?></label>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1">Título</label>
                    <input type="email" class="form-control" id="exampleFormContrInput1" placeholder="Exemplo: Conserto de cano">
                </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Tipo de serviço</label>
                    <select class="selectpicker form-control" data-live-search="true" id="input1">
                        <?php
                        while ($dados = $sql_query->fetch_assoc()) {
                        ?>
                            <option> <?php echo utf8_encode($dados['Nome']) ?></option>

                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Descrição</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="exampleFormContrInput2">Valor</label>
                    <input type="number" class="form-control" id="exampleFormContrInput2" placeholder="Informe o valor do serviço">
                </div>
                <div class="form-group">
                    <label for="exampleFormContrInput3">Prazo</label>
                    <input type="number" class="form-control" id="exampleFormContrInput3" placeholder="Informe o prazo em número de dias">
                </div>
                <div class="form-group" id="submit-buttom">
                    <button type="submit" class="btn btn-success" name="prestar-submit">Postar Serviço</button>
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">Criar Tipo de Serviço</button>
                </div>
            </form>
        </div>


        <!-- Modal -->
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Criar tipo de serviço</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">

                        <form action="" method="POST">
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Nome</label>
                                <input name="nomeAddTipoServico" type="text" class="form-control" id="exampleFormContrInput1" placeholder="Exemplo: Pintar parede">
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect2">Profissões</label>

                                <select name="profissaoAddTipoServico[]" class="selectpicker form-control" multiple data-max-options="3" data-live-search="true" id="input1">
                                    <?php while ($dadosProfissoes = $sql_query_all_professions->fetch_assoc()) {
                                    ?>
                                        <option value="<?php echo utf8_encode($dadosProfissoes['ID']) ?>"><?php echo utf8_encode($dadosProfissoes['Nome']) ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>

                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlTextarea3">Descrição</label>
                                <textarea name="descricaoAddTipoServico" cols="100" class="form-control" id="exampleFormControlTextarea3" rows="5"></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success" name="enviarTipoServ">Criar</button>
                                <button type="buttom" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                            </div>
                    </div>
                    </form>

                </div>

            </div>
        </div>

    </main>



    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integridade="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integridade="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous "></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integridade="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/i18n/defaults-*.min.js"></script>

    <script src="../js/script.js"></script>
</body>

</html>