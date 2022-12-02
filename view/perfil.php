<?php
include "../configDB/connect.php";
include "../login/protect.php";


$cpf = $_SESSION['user'];

$sql_code = "SELECT d.ID, t.Nome AS Tipo_Servico, d.Titulo, d.Descricao, d.Previsao, d.Preco, d.Endereco, d.Status
FROM tipo_servico t JOIN servico d ON d.Tipo_Servico = t.ID and d.prestador = $cpf";

$sql_code_tipos_servico = "SELECT t.nome, ifnull(round(avg(s.preco),2),0) AS media
FROM tipo_servico t LEFT JOIN servico s ON s.Tipo_Servico = t.id
GROUP BY t.nome ORDER BY avg(s.preco) DESC";



try {
    $sql_query = $conn->query($sql_code) or die("Falha na execução do código SQL: " . $conn->error);
    $sql_query_tipos_sevico = $conn->query($sql_code_tipos_servico) or die("Falha na execução do código SQL: " . $conn->error);
} catch (mysqli_sql_exception $error) {
    echo $error;
}

$sql_code_minha_profissao = "SELECT p.ID,p.Nome FROM usuario u join profissao p on u.profissao = p.ID and u.cpf = $cpf";
$sql_code_profissoes = "SELECT ID, Nome From profissao";
$sql_code_valor_pagar = "SELECT Valor_a_Pagar FROM usuario WHERE CPF = $cpf";
$sql_code_valor_receber = "SELECT Valor_a_Receber FROM usuario WHERE CPF = $cpf";

try {
    $sql_query_minha_profissao = $conn->query($sql_code_minha_profissao) or die("Falha em execução do código SQL:" . $conn->error);
    $sql_query_profissoes = $conn->query($sql_code_profissoes) or die();
    $sql_code_valor_pagar = $conn->query($sql_code_valor_pagar) or die("Falha em execução do código SQL:" . $conn->error);
    $sql_code_valor_receber = $conn->query($sql_code_valor_receber) or die("Falha em execução do código SQL:" . $conn->error);
    $profissao =  $sql_query_minha_profissao->fetch_assoc();
    $valor_a_pagar = $sql_code_valor_pagar->fetch_assoc()['Valor_a_Pagar'];
    $valor_a_receber = $sql_code_valor_receber->fetch_assoc()['Valor_a_Receber'];
} catch (mysqli_sql_exception $error) {
    echo $error;
}
$Profissao_mensage = "";
if ($profissao != null) {
    $Profissao_mensage = $profissao['Nome'];
}

if (isset($_POST['enviarProfissao'])) {
    $idProfissao = $_POST['IDProfissao'];
    $sql_code_update_usuario_profissao = "UPDATE usuario SET profissao = $idProfissao WHERE cpf = $cpf";

    try {
        $sql_query_update_usuario_profissao = $conn->query($sql_code_update_usuario_profissao) or die("Falha em execução do código SQL:" . $conn->error);
        header("Refresh:0");
    } catch (mysqli_sql_exception $error) {
        echo $error;
    }
}

if (isset($_GET['filtrar'])) {
    $valorFiltro = $_GET['valorFiltrar'];
    $sql_code_filter_tipo_servico = "SELECT t.nome, ifnull(round(avg(preco),2),0) as media
    FROM servico s RIGHT JOIN tipo_servico t ON s.tipo_servico = t.id
    GROUP BY t.nome
    HAVING ifnull(avg(preco),0) >= 10";

    $sql_query_tipos_sevico = $conn->query($sql_code_filter_tipo_servico) or die("Falha em execução do código SQL:" . $conn->error);
}

if (isset($_GET['voltarFiltro'])) {
    $sql_code = "SELECT d.ID, t.Nome AS Tipo_Servico, d.Titulo, d.Descricao, d.Previsao, d.Preco, d.Endereco, d.Status
    FROM tipo_servico t JOIN servico d ON d.Tipo_Servico = t.ID and d.prestador = $cpf";

    $sql_code_tipos_servico = "SELECT t.nome, ifnull(round(avg(s.preco),2),0) AS media
    FROM tipo_servico t LEFT JOIN servico s ON s.Tipo_Servico = t.id
    GROUP BY t.nome ORDER BY avg(s.preco) DESC";
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
                        <a class="nav-link" href="create-service.php">Criar Serviço</a>
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
            <div class="row title">
                <?php
                if ($Profissao_mensage == "") {
                ?>
                    <h1>Você ainda não possuí profissão</h1>
            </div>
            <div class="row title">
                <div class="form-group">
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">Selecionar profissão</button>
                </div>
            </div>

        <?php
                } else {
        ?>
            <h1>Sua profissão atual é: <?php echo utf8_encode($Profissao_mensage) ?></h1>
        </div>
        <div class="row title">
            <div class="form-group">
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">Trocar profissão</button>
            </div>
        </div>

    <?php
                }


    ?>
    <div class="row content">
        <h3>Valor a receber <span id="valor_a_receber"><?php echo $valor_a_receber ?></span></h3>
        <h3>Valor a pagar <span id="valor_a_pagar"><?php echo $valor_a_pagar ?></span></h3>
    </div>

    <div class="row title">
        <h3>Historico serviços realizados</h3>
    </div>

    <div class="row">
        <div class="col">
            <form action="" method="get">
                <div class="form-outline">
                    <input type="search" id="system-search" class="form-control" placeholder="Pesquisar" aria-label="Search" />
                </div>
            </form>
        </div>


    </div>

    <div class="row">


        <div class="col">
            <table class="table table-list-search">
                <thead>
                    <tr>
                        <th>Tipo</th>
                        <th>Título</th>
                        <th>Descrição</th>
                        <th>Previsao</th>
                        <th>Valor</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($dados = $sql_query->fetch_assoc()) {
                    ?>
                        <tr>
                            <td hidden><input type="text" value="<?php echo $dados['ID'] ?>" name="ID"></td>
                            <td id="teste"><textarea name="tipo_servico" id="" cols="15" readonly><?php echo utf8_encode($dados['Tipo_Servico']) ?></textarea></td>
                            <td><textarea name="titulo" id="" cols="20" readonly><?php echo utf8_encode($dados['Titulo']) ?></textarea></td>
                            <td><textarea name="descricao" id="" cols="30" readonly><?php echo utf8_encode($dados['Descricao']) ?></textarea></td>
                            <td><textarea name="previsao" id="" cols="5" readonly><?php echo utf8_encode($dados['Previsao']) . " dias" ?></textarea></td>
                            <td><textarea name="preco" id="" cols="10" readonly><?php echo utf8_encode($dados['Preco']) ?></textarea></td>
                            <td><textarea name="status" id="" cols="10" readonly><?php echo utf8_encode($dados['Status']) ?></textarea></td>
                        </tr>

                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>

    <div class="row title">
        <h3>Média de valores por tipo de servico</h3>
    </div>

    <div class="row filter">
        <div class="col-xs-3">
            <form method="get" action="">
                <div class="input-group mb-3  inputbutton">
                    <input name="valorFiltrar" type="text" class="form-control" placeholder="Valor maior que: ">
                    <div class="input-group-append">
                        <button name="filtrar" class="btn btn-outline-secondary" type="submit">Filtrar</button>
                        <button name="voltarFiltro" type="submit" class="close" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row tipoServicoList">


        <div class="col-xs-3 ">
            <table class="table table-list-search">
                <thead>
                    <tr>
                        <th>Tipo de servico</th>
                        <th>Média</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($tipoServDado =  $sql_query_tipos_sevico->fetch_assoc()) {
                    ?>
                        <tr>

                            <td><?php echo utf8_encode($tipoServDado['nome']) ?></td>
                            <td><?php echo utf8_encode($tipoServDado['media']) ?></td>


                        </tr>
                    <?php
                    }
                    ?>


                </tbody>
            </table>
        </div>

    </div>







    </div>


    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Trocar profissão</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">

                    <form action="" method="POST">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Tipo de serviço</label>
                            <select name="IDProfissao" class="selectpicker form-control" data-live-search="true" id="input1">
                                <?php
                                while ($profissoes = $sql_query_profissoes->fetch_assoc()) {
                                ?>
                                    <option value="<?php echo $profissoes['ID'] ?>"><?php echo utf8_encode($profissoes['Nome']) ?></option>
                                <?php
                                }
                                ?>



                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success" name="enviarProfissao">Selecionar</button>
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