<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$nome = $cognome = $dataNascita = "";
$nome_err = $cognome_err = $dataNascita_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate nome
    $input_nome = trim($_POST["nome"]);
    if (empty($input_nome)) {
        $nome_err = "Please enter a name.";
    } elseif (!filter_var($input_nome, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $nome_err = "Please enter a valid name.";
    } else {
        $nome = $input_nome;
    }

    // Validate cognome
    $input_cognome = trim($_POST["cognome"]);
    if (empty($input_cognome)) {
        $cognome_err = "Please enter an address.";
    } else {
        $cognome = $input_cognome;
    }

    // Validate dataNascita
    $input_dataNascita = trim($_POST["dataNascita"]);
    if (empty($input_dataNascita)) {
        $dataNascita_err = "Please enter the salary amount.";
    } elseif (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $dataNascita)) {
        $dataNascita_err = "Please enter a positive integer value.";
    } else {
        $dataNascita = $input_dataNascita;
    }

    // Check input errors before inserting in database
    if (empty($nome_err) && empty($cognome_err) && empty($dataNascita_err)) {
        // Prepare an insert statement
        echo $dataNascita;
        $sql = "INSERT INTO utente (nome, cognome, data_nascita) VALUES (?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_nome, $param_cognome, $param_dataNascita);

            // Set parameters
            $param_nome = $nome;
            $param_cognome = $cognome;
            $param_dataNascita = $dataNascita;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Records created successfully. Redirect to landing page
                $lastPath = file_get_contents('config.txt');
                header("location: $lastPath");
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper {
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill this form and submit to add employee record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Nome</label>
                            <input type="text" name="nome" class="form-control <?php echo (!empty($nome_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $nome; ?>">
                            <span class="invalid-feedback"><?php echo $nome_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Cognome</label>
                            <input type="text" name="cognome" class="form-control <?php echo (!empty($cognome_err)) ? 'is-invalid' : ''; ?>"><?php echo $cognome; ?></input>
                            <span class="invalid-feedback"><?php echo $cognome_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Data Nascita</label>
                            <input type="date" name="dataNascita" class="form-control <?php echo (!empty($dataNascita_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $dataNascita; ?>">
                            <span class="invalid-feedback"><?php echo $dataNascita_err; ?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>