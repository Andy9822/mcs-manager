<?php
// Include config file
require_once 'config.php';

// Define variables and initialize with empty values
$id = $description = $capacity = $resolution = $date = $time = $duration = $originalId = "";
$id_err = $date_err = $time_err = "";

// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){

    // Validate ID
    $id = trim($_POST["id"]);
    if(empty($id)){
        $id_err = "Escolha um ID para a sala.";
    }
    else {
      //Check if the new ID is used by another room
      $originalId = trim($_POST["originalId"]);
      if ($originalId != $id) {
        $idQuery ="SELECT * FROM rooms WHERE id = :id";
        if($stmt = $pdo->prepare($idQuery)){
          $stmt->bindParam(':id', $id);
          if($stmt->execute()){
              if($stmt->rowCount() != 0 ){
                $id_err = "ID de sala já em uso, tente outro valor";
            }
          }
        }
      }
    }

    // Get description
    $description = trim($_POST["description"]);

    // Get capacity
    $capacity = trim($_POST["capacity"]);

    // Get resolution
    $resolution = trim($_POST["resolution"]);

    // Validate date
    $date = trim($_POST["date"]);
    if(empty($date)){
        $date_err = "Escolha uma data.";
      }

    // Validate time
    $time = trim($_POST["time"]);
    if(empty($time)){
        $time_err = "Escolha um horário.";
      }

    // Get duration
    $duration = trim($_POST["duration"]);

    // Check input errors before inserting in database
    if(empty($id_err) && empty($date_err) && empty($time_err)){
        // Prepare an insert statement
        $sql = "UPDATE rooms SET id=:id, description=:description, capacity=:capacity, resolution=:resolution, par_date=:par_date, par_time=:par_time,  duration=:duration WHERE id=:id";

        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':capacity', $capacity);
            $stmt->bindParam(':resolution', $resolution);
            $stmt->bindParam(':par_date', $date);
            $stmt->bindParam(':par_time', $time);
            $stmt->bindParam(':duration', $duration);

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records updated successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }

        // Close statement
        unset($stmt);
    }

    // Close connection
    unset($pdo);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);

        // Prepare a select statement
        $sql = "SELECT * FROM rooms WHERE id = :id";
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(':id', $param_id);

            // Set parameters
            $param_id = $id;

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    // Retrieve individual field value
                    $id = $row["id"];
                    $description = $row["description"];
                    $capacity = $row["capacity"];
                    $resolution = $row["resolution"];
                    $date = $row["par_date"];
                    $time = $row["par_time"];
                    $duration = $row["duration"];
                    $originalId = $id;
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }

            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        unset($stmt);

        // Close connection
        unset($pdo);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
  <div class="wrapper">
      <div class="container-fluid">
          <div class="row">
              <div class="col-md-12">
                  <div class="page-header">
                      <h2>Editar Sala</h2>
                  </div>
                  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                      <div class="form-group <?php echo (!empty($id_err)) ? 'has-error' : ''; ?>">
                          <label>ID</label>
                          <input readonly type="text" name="id" class="form-control" maxlength="6" value="<?php echo $id; ?>">
                          <span class="help-block"><?php echo $id_err;?></span>
                      </div>
                      <div class="form-group ">
                          <label>Descrição</label>
                          <input type="text" name="description" class="form-control" maxlength="15" value="<?php echo $description; ?>">
                      </div>
                      <div class="form-group ">
                          <label>Capacidade</label>
                          <select id = "capacityList" name="capacity" class="form-control">
                            <option value="2">2 pessoas</option>
                            <option value="3">3 pessoas</option>
                            <option value="4">4 pessoas</option>
                            <option value="5">5 pessoas</option>
                            <option value="6">6 pessoas</option>
                            <option value="7">7 pessoas</option>
                            <option value="8">8 pessoas</option>
                            <option value="9">9 pessoas</option>
                          </select>
                      </div>
                      <div class="form-group ">
                          <label>Resolução</label>
                          <select id = "resolutionList" name="resolution" class="form-control">
                            <option value="480">480p SD</option>
                            <option value="720">720p HD</option>
                          </select>
                      </div>
                      <div class="form-group <?php echo (!empty($date_err)) ? 'has-error' : ''; ?>">
                          <label>Data</label>
                          <input type="date" name="date" class="form-control" value="<?php echo $date; ?>">
                          <span class="help-block"><?php echo $date_err;?></span>
                      </div>
                      <div class="form-group <?php echo (!empty($time_err)) ? 'has-error' : ''; ?>">
                          <label>Hora</label>
                          <input type="time" name="time" class="form-control" value="<?php echo $time; ?>">
                          <span class="help-block"><?php echo $time_err;?></span>
                      </div>
                      <div class="form-group">
                          <label>Duração</label>
                          <select id = "durationList" name="duration" class="form-control">
                            <option value="2">2 horas</option>
                            <option value="3">3 horas</option>
                            <option value="4">4 horas</option>
                            <option value="5">5 horas</option>
                            <option value="6">6 horas</option>
                            <option value="7">7 horas</option>
                            <option value="8">8 horas</option>
                            <option value="9">9 horas</option>
                            <option value="10">10 horas</option>
                            <option value="11">11 horas</option>
                            <option value="12">12 horas</option>
                          </select>
                      </div>
                      <input type="hidden" name="originalId" value="<?php echo $originalId; ?>"/>
                      <a href="index.php" class="btn btn-default">Cancelar</a>
                      <input type="submit" class="btn btn-primary" value="Salvar ">
                  </form>
              </div>
          </div>
      </div>
  </div>
  <script>
  document.getElementById('resolutionList').selectedIndex=<?php echo ($resolution == '720') ? 1 : 0 ?>;
  document.getElementById('capacityList').selectedIndex=<?php echo $capacity-2 ?>;
  document.getElementById('durationList').selectedIndex=<?php echo $duration-2 ?>;
</script>
</body>
</html>
