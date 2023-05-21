<?php
// Include config file
require_once "../config.php";

// Define variables and initialize with empty values
$nomeCorso = $nomeIstruttore = $dataNascita = "";
$nomeCorso_err = $nomeIstruttore_err = $dataNascita_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate nome
    $input_corso = trim($_POST["selectNomeCorso"]);
    if (empty($input_nome)) {
        $nomeCorso_err = "Please enter a name.";
    } else {
        $nomeCorso = $input_nomeCorso;
    }

    // Validate cognome
    $input_nomeIstruttore = trim($_POST["selectIstruttoreCorso"]);
    if (empty($input_nomeIstruttore)) {
        $nomeIstruttore_err = "Please enter an address.";
    } else {
        $nomeIstruttore = $input_nomeIstruttore;
    }

    // Validate dataNascita
    $input_dataNascita = trim($_POST["dataNascita"]);
    if (empty($input_dataNascita)) {
        $dataNascita_err = "Inserisci la data di nascita.";
    } elseif (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $dataNascita)) {
        $dataNascita_err = "Inserisci la data di nascita.";
    } else {
        $dataNascita = $input_dataNascita;
    }

    // Check input errors before inserting in database
    if (empty($nomeCorso_err) && empty($cognome_err) && empty($dataNascita_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO corso (nome_id, istruttore_id, data_nascita) VALUES (?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_nomeCorso, $param_nomeIstruttore, $param_dataNascita);

            // Set parameters
            $param_nomeCorso = $nomeCorso;
            $param_nomeIstruttore = $nomeIstruttore;
            $param_dataNascita = $dataNascita;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Records created successfully. Redirect to landing page
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
                    <h2 class="mt-5">Inserisci Record</h2>
                    <p>Compila questo modulo.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Nome Corso</label>
                            <select name="selectNomeCorso" class="form-control <?php echo (!empty($nomeCorso_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $nomeCorso; ?>">
                                <!-- <option value="" selected disabled hidden>Seleziona</option> -->

                                <?php
                                require_once "../config.php";

                                if (!isset($_POST['selectNomeCorso']) || empty($_POST['selectNomeCorso'])) {
                                    echo '<option value="" selected disabled hidden>Seleziona</option>';
                                }

                                // Visualizza iscritti corso
                                $sqlNomeCorso = "SELECT nome_corso.nome
                                                    FROM nome_corso
                                                    ORDER BY nome_corso.nome;";

                                if ($resultNomeCorso = mysqli_query($link, $sqlNomeCorso)) {
                                    if (mysqli_num_rows($resultNomeCorso) > 0) {
                                        while ($rowNomeCorso = mysqli_fetch_array($resultNomeCorso)) {
                                            $setSelect = 'selected';
                                            if ($nomeCorso == $rowNomeCorso['nome']) {
                                                echo '<option value="' . $rowNomeCorso['nome'] . '" ' . $setSelect . '  >' . $rowNomeCorso['nome'] . '</option>';
                                            } else {
                                                echo '<option value="' . $rowNomeCorso['nome'] . '">' . $rowNomeCorso['nome'] . '</option>';
                                            }
                                        }
                                        // Free result set
                                        mysqli_free_result($resultNomeCorso);
                                    } else {
                                        echo '<div class="alert alert-danger"><em>Non è stato trovato nessun record.</em></div>';
                                    }
                                } else {
                                    echo "Oops! Something went wrong. Please try again later.";
                                }
                                ?>
                            </select>
                            <span class="invalid-feedback"><?php echo $nomeCorso_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Istruttore</label>
                            <select name="selectIstruttoreCorso" class="form-control <?php echo (!empty($nomeIstruttore_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $nomeIstruttore; ?>">
                                <!-- <option value="" selected disabled hidden>Seleziona</option> -->

                                <?php
                                require_once "../config.php";

                                if (!isset($_POST['selectIstruttoreCorso']) || empty($_POST['selectIstruttoreCorso'])) {
                                    echo '<option value="" selected disabled hidden>Seleziona</option>';
                                }

                                // Visualizza iscritti corso
                                $sqlIstruttoreCorso = "SELECT istruttore.nome, istruttore.cognome, istruttore.id
                                                    FROM istruttore";

                                if ($resultIstruttoreCorso = mysqli_query($link, $sqlIstruttoreCorso)) {
                                    if (mysqli_num_rows($resultIstruttoreCorso) > 0) {
                                        while ($rowIstruttoreCorso = mysqli_fetch_array($resultIstruttoreCorso)) {
                                            $setSelect = 'selected';
                                            if ($nomeIstruttore == $rowIstruttoreCorso['id']) {
                                                echo '<option value="' . $rowIstruttoreCorso['id'] . '" ' . $setSelect . '  >' . $rowIstruttoreCorso['nome'] . ' ' . $rowIstruttoreCorso['cognome'] . '</option>';
                                            } else {
                                                echo '<option value="' . $rowIstruttoreCorso['id'] . '">' . $rowIstruttoreCorso['nome'] . ' ' . $rowIstruttoreCorso['cognome'] . '</option>';
                                            }
                                        }
                                        // Free result set
                                        mysqli_free_result($resultIstruttoreCorso);
                                    } else {
                                        echo '<div class="alert alert-danger"><em>Non è stato trovato nessun record.</em></div>';
                                    }
                                } else {
                                    echo "Oops! Something went wrong. Please try again later.";
                                }
                                ?>
                            </select>
                            <span class="invalid-feedback"><?php echo $nomeIstruttore_err; ?></span>
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
                        <input type="submit" class="btn btn-primary" value="Invio">
                        <!-- <a href="index.php" class="btn btn-secondary ml-2">Annulla</a> -->
                        <a href="<?php echo file_get_contents('../config.txt'); ?>" class="btn btn-secondary ml-2">Annulla</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>