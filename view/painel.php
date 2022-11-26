<?php
include "../login/protect.php";
include "../configDB/connect.php";

$sql_code = "SELECT * FROM"

?>

<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv=”Content-Type” content=”text/html; charset=utf-8″>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel</title>

  <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
</head>
<body>
    Bem vindo, <?php echo $_SESSION['name']?>
    <p>
        <a href="../login/logout.php">Sair</a>
    </p>

  <div class="container">
	<div class="row">
        <div class="col-md-3">
            <form action="#" method="get">
                <div class="input-group">
                    <input class="form-control" id="system-search" name="q" placeholder="Search for" required>
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i></button>
                    </span>
                </div>
            </form>
        </div>
		<div class="col-md-9">
    	 <table class="table table-list-search">
                    <thead>
                        <tr>
                            <th>Tipo de Serviço</th>
                            <th>Título</th>
                            <th>Descrição</th>
                            <th>Previsao</th>
                            <th>Valor do serviço</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Sample</td>
                            <td>Filter</td>
                            <td>12-11-2011 11:11</td>
                            <td>OK</td>
                            <td>123</td>
                            <td>Do some other</td>
                        </tr>
                        <tr>
                            <td>Try</td>
                            <td>It</td>
                            <td>11-20-2013 08:56</td>
                            <td>It</td>
                            <td>Works</td>
                            <td>Do some FILTERME</td>
                        </tr>
                        <tr>
                            <td>§</td>
                            <td>$</td>
                            <td>%</td>
                            <td>&</td>
                            <td>/</td>
                            <td>!</td>
                        </tr>
                    </tbody>
                </table>   
		</div>
	</div>
</div>
</body>
</html>

