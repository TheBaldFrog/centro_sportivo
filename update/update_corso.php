<?php
// Include config file
require_once "../config.php";

// Define variables and initialize with empty values
$nomeCorso = $nomeIstruttore = $giornoSettimana = "";
$nomeCorso_err = $nomeIstruttore_err = $giornoSettimana_err = "";
$appt = $costo = $numLezioni = "";
$appt_err = $costo_err = $numLezioni_err = "";

// Processing form data when form is submitted
if (isset($_POST["id"]) && !empty($_POST["id"])) {
    // Get hidden input value
    $id = $_POST["id"];

    // Validate nome
    $input_nomeCorso = trim($_POST["selectNomeCorso"]);
    if (empty($input_nomeCorso)) {
        $nomeCorso_err = "Please enter a name.";
    } else {
        $nomeCorso = $input_nomeCorso;
    }

    // Validate cognome
    $input_nomeIstruttore = trim($_POST["selectIstruttoreCorso"]);
    if (empty($input_nomeIstruttore)) {
        $nomeIstruttore_err = "Please enter the salary amount.";
    } else {
        $nomeIstruttore = $input_nomeIstruttore;
        // echo $nomeIstruttore;
    }

    // Validate giornoSettimana
    $input_giornoSettimana = trim($_POST["giornoSettimana"]);
    if (empty($input_giornoSettimana)) {
        $giornoSettimana_err = "Inserisci giornoSettimana.";
    } else {
        $giornoSettimana = $input_giornoSettimana;
    }

    $input_appt = trim($_POST["appt"]);
    if (empty($input_appt)) {
        $appt_err = "Inserisci orario";
    } else {
        $appt = $input_appt;
    }

    $input_numLezioni = trim($_POST["numLezioni"]);
    if (empty($input_numLezioni)) {
        $numLezioni_err = "Inserisci num Lezioni";
    } elseif ($input_numLezioni < 0 || $input_numLezioni > 200) {
        $numLezioni_err = "0 < Numero Lezioni < 200";
    } else {
        $numLezioni = $input_numLezioni;
    }

    $input_costo = trim($_POST["costo"]);
    if (empty($input_costo)) {
        $costo_err = "Inserisci costo";
    } elseif ($input_costo < 0) {
        $costo_err = "costo > 0";
    } else {
        $costo = $input_costo;
        echo $costo;
    }

    // Check input errors before inserting in database
    if (empty($nomeCorso_err) && empty($nomeIstruttore_err) && empty($numLezioni_err) && empty($costo_err)) {
        // Prepare an update statement
        //$sql = "UPDATE employees SET name=?, address=?, salary=? WHERE id=?";
        $sql = "UPDATE corso SET nome_id=?, istruttore_id=?, giorno_settimana=?, orario_prefissato=?, numero_lezioni=?, costo_iscrizione=? WHERE id=?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sissiii", $param_nomeCorso, $param_nomeIstruttore, $param_giornoSettimana, $param_appt, $param_numLezioni, $param_costo, $param_id);
            // Set parameters
            $param_nomeCorso = $nomeCorso;
            $param_nomeIstruttore = $nomeIstruttore;
            $param_giornoSettimana = $giornoSettimana;
            $param_appt = $appt;
            $param_id = $id;
            $param_numLezioni = $numLezioni;
            $param_costo = $costo;

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
    // mysqli_close($link);
} else {
    // Check existence of id parameter before processing further
    if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
        // Get URL parameter
        $id =  trim($_GET["id"]);

        // Prepare a select statement
        $sql = "SELECT * FROM corso WHERE id = ?";
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
                    $nomeCorso = $row["nome_id"];
                    $nomeIstruttore = $row["istruttore_id"];
                    $giornoSettimana = $row["giorno_settimana"];
                    $appt = $row["orario_prefissato"];
                    $numLezioni = $row["numero_lezioni"];
                    $costo = $row["costo_iscrizione"];
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
        // mysqli_close($link);
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
                            <label>Giorno Settimana</label>
                            <select name="giornoSettimana" class="form-control <?php echo (!empty($giornoSettimana_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $giornoSettimana; ?>">
                                <?php
                                require_once "../config.php";

                                if ($giornoSettimana == "lunedì") {
                                    echo '<option value="lunedì" selected>lunedì</option>';
                                } else {
                                    echo '<option value="lunedì">lunedì</option>';
                                }
                                if ($giornoSettimana == "martedì") {
                                    echo '<option value="martedì" selected>martedì</option>';
                                } else {
                                    echo '<option value="martedì">martedì</option>';
                                }
                                if ($giornoSettimana == "mercoledì") {
                                    echo '<option value="mercoledì" selected>mercoledì</option>';
                                } else {
                                    echo '<option value="mercoledì">mercoledì</option>';
                                }
                                if ($giornoSettimana == "giovedì") {
                                    echo '<option value="giovedì" selected>giovedì</option>';
                                } else {
                                    echo '<option value="giovedì">giovedì</option>';
                                }
                                if ($giornoSettimana == "venerdì") {
                                    echo '<option value="venerdì" selected>venerdì</option>';
                                } else {
                                    echo '<option value="venerdì">venerdì</option>';
                                }
                                if ($giornoSettimana == "sabato") {
                                    echo '<option value="sabato" selected>sabato</option>';
                                } else {
                                    echo '<option value="sabato">sabato</option>';
                                }
                                if ($giornoSettimana == "domenica") {
                                    echo '<option value="domenica" selected>domenica</option>';
                                } else {
                                    echo '<option value="domenica">domenica</option>';
                                }
                                ?>
                            </select>
                            <span class="invalid-feedback"><?php echo $giornoSettimana_err; ?></span>
                        </div>

                        <div class="form-group">
                            <label>Orario (09:00 - 20:00)</label>
                            <input type="time" name="appt" min="09:00" max="20:00" required class="form-control <?php echo (!empty($appt_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $appt; ?>">
                            <span class="invalid-feedback"><?php echo $appt_err; ?></span>
                        </div>

                        <div class="form-group">
                            <label>Numero Lezioni</label>
                            <input type="text" name="numLezioni" class="form-control <?php echo (!empty($numLezioni_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $numLezioni; ?>">
                            <span class="invalid-feedback"><?php echo $numLezioni_err; ?></span>
                        </div>

                        <div class="form-group">
                            <label>Costo iscrizione</label>
                            <input type="text" name="costo" class="form-control <?php echo (!empty($costo_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $costo; ?>">
                            <span class="invalid-feedback"><?php echo $costo_err; ?></span>
                        </div>

                        <input type="hidden" name="id" value="<?php echo $id; ?>" />
                        <input type="submit" class="btn btn-primary" value="Invio">
                        <a href="<?php echo file_get_contents('../config.txt'); ?>" class="btn btn-secondary ml-2">Annulla</a>
                    </form>

                </div>
            </div>
        </div>
    </div>
</body>

</html>