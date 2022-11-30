<?php
include "../configDB/connect.php";
include "../login/protect.php";

$sql_code = "SELECT d.ID, t.Nome AS Tipo_Servico, d.Titulo, d.Descricao, d.Previsao, d.Preco, d.Endereco, d.Status
FROM tipo_servico t JOIN servico d ON d.Tipo_Servico = t.ID AND d.status = 4;";
$sql_query = $conn->query($sql_code) or die("Falha na execução do código SQL: " . $conn->error);
$qtd = $sql_query->num_rows;

if (isset($_POST['prestar-submit'])) {
    $id = $_POST['ID'];
    $cpf = $_SESSION['user'];
    $sql_baterProfissao = "SELECT count(*) FROM servico d JOIN tipo_servico t ON  d.ID = $id AND t.ID = d.Tipo_Servico JOIN usuario u ON u.cpf =  $cpf  AND u.profissao = t.ID_Profissao";

    $sql_query2 = $conn->query($sql_baterProfissao) or die("Falha na execusão do código SQL: " . $conn->error);

    if ($sql_query2->num_rows == 1) {
        $sql_ADD_Prestador = "UPDATE servico
        set Prestador = $cpf WHERE ID = $id";

        $sql_ADD_Data_Inicio = "UPDATE servico
        set Data_Inicio = CURDATE() WHERE ID = $id";

        $sql_IniciarServ = "UPDATE servico 
        set Status = 2 WHERE ID = $id";

        try {
            $sql_query3 = $conn->query($sql_ADD_Prestador) or die("Falha na execusão do código SQL: " . $conn->error);
            $sql_query4 = $conn->query($sql_ADD_Data_Inicio) or die("Falha na execusão do código SQL: " . $conn->error);
            $sql_query5 = $conn->query($sql_IniciarServ) or die("Falha na execusão do código SQL: " . $conn->error);
            header("Refresh:0");
        } catch (mysqli_sql_exception $error) {
            echo $error;
        }
    }else {
        //Do something...
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

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
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

    <div class="container">
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
                            <form action="" method="post">
                                <tr>
                                    <td hidden><input type="text" value="<?php echo $dados['ID'] ?>" name="ID"></td>
                                    <td id="teste"><textarea name="tipo_servico" id="" cols="15" readonly><?php echo utf8_encode($dados['Tipo_Servico']) ?></textarea></td>
                                    <td><textarea name="titulo" id="" cols="20" readonly><?php echo utf8_encode($dados['Titulo']) ?></textarea></td>
                                    <td><textarea name="descricao" id="" cols="30" readonly><?php echo utf8_encode($dados['Descricao']) ?></textarea></td>
                                    <td><textarea name="previsao" id="" cols="5" readonly><?php echo utf8_encode($dados['Previsao']) . " dias" ?></textarea></td>
                                    <td><textarea name="preco" id="" cols="10" readonly><?php echo utf8_encode($dados['Preco']) ?></textarea></td>
                                    <td><textarea name="status" id="" cols="10" readonly><?php echo utf8_encode($dados['Status']) ?></textarea></td>
                                    <td><button type="submit" class="btn btn-success" name="prestar-submit">Prestar</button></td>
                                </tr>
                            </form>

                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>


    <script src="../js/script.js"></script>
</body>

</html>