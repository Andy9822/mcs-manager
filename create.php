<?php
// Include config file
require_once 'config.php';

// Define variables and initialize with empty values
$id = $description = $capacity = $resolution = $date = $time = $duration = "";
$id_err = $date_err = $time_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate ID
    $id = trim($_POST["id"]);
    if(empty($id)){
        $id_err = "Escolha um ID para a sala.";
    }
    else {
      $idQuery ="SELECT * FROM rooms WHERE id = :id";
      if($stmt = $pdo->prepare($idQuery)){
        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(':id', $id);
        if($stmt->execute()){
            // Records created successfully. Redirect to landing page
            if($stmt->rowCount() != 0){
              $id_err = "ID de sala já em uso, tente outro valor";
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
        $sql = "INSERT INTO rooms (id, description, capacity, resolution, par_date, par_time, duration) VALUES (:id, :description, :capacity, :resolution, :par_date, :par_time, :duration)";

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
                // Records created successfully. Redirect to landing page
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
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
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
                        <h2>Criar Sala</h2>
                    </div>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($id_err)) ? 'has-error' : ''; ?>">
                            <label>ID</label>
                            <input type="text" name="id" class="form-control" maxlength="6" onkeypress='return event.charCode >= 48 && event.charCode <= 57' value="<?php echo $id; ?>">
                            <span class="help-block"><?php echo $id_err;?></span>
                        </div>
                        <div class="form-group ">
                            <label>Descrição</label>
                            <input type="text" name="description" class="form-control" maxlength="15" value="<?php echo $description; ?>">
                        </div>
                        <div class="form-group ">
                            <label>Capacidade</label>
                            <select name="capacity" class="form-control">
                              <option value="2">2 pessoas</option>
                              <option value="3">3 pessoas</option>
                              <option value="4" selected = "selected">4 pessoas</option>
                              <option value="5">5 pessoas</option>
                              <option value="6">6 pessoas</option>
                              <option value="7">7 pessoas</option>
                              <option value="8">8 pessoas</option>
                              <option value="9">9 pessoas</option>
                            </select>
                        </div>
                        <div class="form-group ">
                            <label>Resolução</label>
                            <select name="resolution" class="form-control">
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
                            <select name="duration" class="form-control">
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
                        <a href="index.php" class="btn btn-default">Cancelar</a>
                        <input type="submit" class="btn btn-primary" value="Salvar ">
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
