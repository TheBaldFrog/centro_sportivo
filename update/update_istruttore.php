<?php
// Include config file
require_once "../config.php";

// Define variables and initialize with empty values
$nome = $cognome = $descrizione = "";
$nome_err = $cognome_err = $descrizione_err = "";

// Processing form data when form is submitted
if (isset($_POST["id"]) && !empty($_POST["id"])) {
    // Get hidden input value
    $id = $_POST["id"];

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
        $cognome_err = "Please enter the salary amount.";
    } else {
        $cognome = $input_cognome;
    }

    // Validate dataNascita
    $input_descrizione = trim($_POST["descrizione"]);
    if (empty($input_descrizione)) {
        $descrizione_err = "Inserisci la descrizione.";
    } elseif (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $descrizione)) {
        $descrizione_err = "Inserisci la descrizione.";
    } else {
        $descrizione = $input_descrizione;
    }

    // Check input errors before inserting in database
    if (empty($nome_err) && empty($cognome_err) && empty($descrizione_err)) {
        // Prepare an update statement
        //$sql = "UPDATE employees SET name=?, address=?, salary=? WHERE id=?";
        $sql = "UPDATE istruttore SET nome=?, cognome=?, descrizione=? WHERE id=?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssi", $param_nome, $param_cognome, $param_descrizione, $param_id);

            // Set parameters
            $param_nome = $nome;
            $param_cognome = $cognome;
            $param_descrizione = $descrizione;
            $param_id = $id;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Records updated successfully. Redirect to landing page
                $lastPath = file_get_contents('../config.txt');
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
} else {
    // Check existence of id parameter before processing further
    if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
        // Get URL parameter
        $id =  trim($_GET["id"]);

        // Prepare a select statement
        $sql = "SELECT * FROM istruttore WHERE id = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);

            // Set parameters
            $param_id = $id;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);

                if (mysqli_num_rows($result) == 1) {
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                    // Retrieve individual field value
                    $nome = $row["nome"];
                    $cognome = $row["cognome"];
                    $descrizione = $row["descrizione"];
                } else {
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);

        // Close connection
        mysqli_close($link);
    } else {
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
                    <h2 class="mt-5">Aggiorna Record</h2>
                    <p>Compila questo modulo</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>Nome</label>
                            <input type="text" name="nome" class="form-control <?php echo (!empty($nome_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $nome; ?>">
                            <span class="invalid-feedback"><?php echo $nome_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Cognome</label>
                            <textarea name="cognome" class="form-control <?php echo (!empty($cognome_err)) ? 'is-invalid' : ''; ?>"><?php echo $cognome; ?></textarea>
                            <span class="invalid-feedback"><?php echo $cognome_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Descrizione</label>
                            <textarea name="descrizione" rows="4" class="form-control <?php echo (!empty($descrizione_err)) ? 'is-invalid' : ''; ?>"><?php echo $descrizione; ?></textarea>
                            <span class="invalid-feedback"><?php echo $descrizione_err; ?></span>
                        </div>

                        <input type="hidden" name="id" value="<?php echo $id; ?>" />
                        <input type="submit" class="btn btn-primary" value="Invio">
                        <a href="<?php echo file_get_contents('../config.txt'); ?>" class="btn btn-secondary ml-2">Annulla</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>

</html>