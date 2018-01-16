<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <style type="text/css">
        .wrapper{
            margin: 0 auto;
        }
        .page-header h2{
            margin-top: 0;
        }
        table tr td:last-child a{
            margin-right: 15px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</head>
<body>
 <div id="main" class="container-fluid" style="margin-top: 50px">
    <nav class="navbar navbar-inverse navbar-fixed-top">
     <div class="container-fluid">
      <div class="navbar-header">
       <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
       </button>
       <a class="navbar-brand" href="index.php">GTMCU Painel</a>
      </div>
     </div>
    </nav>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                        <h2 class="pull-left">Salas de Videconferencia</h2>
                        <a href="create.php" class="btn btn-success pull-right">Criar nova sala</a>
                    </div>
                    <?php
                    // Include config file
                    require_once 'config.php';

                    // Attempt select query execution
                    $sql = "SELECT * FROM rooms";
                    if($result = $pdo->query($sql)){
                        if($result->rowCount() > 0){
                          echo "<div id='list' class='row'>";
                          echo "<div class='table-responsive col-md-12'>";
                            echo "<table class='table  table-striped' cellspacing='0' cellpadding='0'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>ID</th>";
                                        echo "<th>Descrição</th>";
                                        echo "<th>Capacidade</th>";
                                        echo "<th>Resolução</th>";
                                        echo "<th>Data</th>";
                                        echo "<th>Horario</th>";
                                        echo "<th>Duração</th>";
                                        echo "<th>Ações</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = $result->fetch()){
                                  $quality = ($row['resolution'] == '720') ? 'HD' : 'SD';
                                  $date = date("d-m-Y", strtotime($row['par_date']));
                                    echo "<tr>";
                                        echo "<td>" . $row['id'] . "</td>";
                                        echo "<td>" . $row['description'] . "</td>";
                                        echo "<td>" . $row['capacity'] . " usuarios</td>";
                                        echo "<td>" . $row['resolution'] . "p ". $quality. "</td>";
                                        echo "<td>" . $date . "</td>";
                                        echo "<td>" . $row['par_time'] . "</td>";
                                        echo "<td>" . $row['duration'] . " horas</td>";
                                        echo "<td>";
                                            echo "<a href='update.php?id=". $row['id'] ."' class='btn btn-warning btn-xs' title='Editar Sala' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                                            echo "<a href='delete.php?id=". $row['id'] ."' class='btn btn-danger btn-xs'title='Deletar Sala' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";
                            echo "</table>";
                          echo "</div>";
                          echo "</div>";
                            // Free result set
                            unset($result);
                        } else{
                            echo "<p class='lead'><em>Não existe nenhuma sala.</em></p>";
                        }
                    } else{
                        echo "ERROR: Could not able to execute $sql. " . $mysqli->error;
                    }

                    // Close connection
                    unset($pdo);
                    ?>
                </div>
            </div>
        </div>
    </div>
 </div> <!-- /#main -->
</body>
</html>
