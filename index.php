<?php
$lastPath = $actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
file_put_contents('config.txt', $lastPath);
//echo file_get_contents('config.txt');

// My var
if (isset($_POST['formSelectUtentiFromCorso']) && !empty($_POST['formSelectUtentiFromCorso'])) {
    $hh = $_POST['formSelectUtentiFromCorso'];
}
?>


<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="style.css">

</head>

<body>
    <div id="wrapper">

        <?php
        // SideBar
        echo file_get_contents("components/sidebar.php");
        ?>

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">


                <div class="row d-flex justify-content-around">
                    <div class="col-auto col-md-11">
                        <div class="mt-3 mb-3 clearfix">
                            <h2 class="pull-left">Corsi</h2>
                            <a href="create.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Aggiungi </a>
                        </div>

                        <?php
                        // Include config file
                        require_once "config.php";

                        // Visualizza corso
                        $sql = "SELECT corso.*, istruttore.nome
                                FROM corso
                                Inner Join istruttore on corso.istruttore_id = istruttore.id
                                Order by corso.id;";
                        if ($result = mysqli_query($link, $sql)) {
                            if (mysqli_num_rows($result) > 0) {
                                echo '<table class="table text-nowrap table-bordered table-striped">';
                                echo "<thead>";
                                echo "<tr>";
                                echo "<th>#</th>";
                                echo "<th>Nome Corso</th>";
                                echo "<th>Istruttore</th>";
                                echo "<th>Giorno Settimana</th>";
                                echo "<th>Orario Prefissato</th>";
                                echo "<th>Numero Lezioni</th>";
                                echo "<th>Costo Iscrizione</th>";
                                echo "<th>Totali iscritti</th>";
                                echo "<th style='text-align: center;'>Action</th>";
                                echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while ($row = mysqli_fetch_array($result)) {
                                    echo "<tr>";
                                    echo "<td>" . $row['id'] . "</td>";
                                    echo "<td>" . $row['nome_id'] . "</td>";
                                    echo "<td>" . $row['nome'] . "</td>";
                                    echo "<td>" . $row['giorno_settimana'] . "</td>";
                                    echo "<td>" . $row['orario_prefissato'] . "</td>";
                                    echo "<td>" . $row['numero_lezioni'] . "</td>";
                                    echo "<td>" . $row['costo_iscrizione'] . "</td>";

                                    $idCorso = $row['id'];
                                    $sqltotaliIscritti =        "SELECT COUNT(prenotazione.utente_id)
                                                                FROM prenotazione
                                                                WHERE prenotazione.corso_id = $idCorso;";

                                    if ($totaliIscritti = mysqli_query($link, $sqltotaliIscritti)) {
                                        $rowTotaliIscritti = mysqli_fetch_array($totaliIscritti);
                                        echo "<td>" . $rowTotaliIscritti[0] . "</td>";
                                    }

                                    echo "<td>";
                                    echo "<div class='d-flex justify-content-around'>";
                                    echo '<a href="update.php?id=' . $row['id'] . '" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                    echo '<a href="delete.php?id=' . $row['id'] . '&tb=corso" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                                    echo "</div>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";
                                echo "</table>";
                                // Free result set
                                mysqli_free_result($result);
                            } else {
                                echo '<div class="alert alert-danger"><em>Non è stato trovato nessun record</em></div>';
                            }
                        } else {
                            echo "Oops! Something went wrong. Please try again later.";
                        }
                        ?>
                    </div>
                </div>


                <div class="row d-flex justify-content-around">
                    <div class="col-auto col-md-11">
                        <div class="mt-3 mb-3 clearfix">
                            <?php
                            if (!isset($_POST['formSelectUtentiFromCorso']) || empty($_POST['formSelectUtentiFromCorso'])) {
                                echo '<h2 class="pull-left">Inscritti corso</h2>';
                            }

                            if (isset($_POST['formSelectUtentiFromCorso']) && !empty($_POST['formSelectUtentiFromCorso'])) {
                                echo "<h2 class='pull-left'>Inscritti corso $hh</h2>";
                            }

                            ?>

                            <form class="pull-right" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                <div class="row">
                                    <div class="col-auto">
                                        <select class="form-control" name="formSelectUtentiFromCorso">
                                            <!-- <option value="" selected disabled hidden>Seleziona</option> -->

                                            <?php
                                            require_once "config.php";

                                            if (!isset($_POST['formSelectUtentiFromCorso']) || empty($_POST['formSelectUtentiFromCorso'])) {
                                                echo '<option value="" selected disabled hidden>Seleziona</option>';
                                            }

                                            // Visualizza inscritti corso
                                            $sql = "SELECT nome_corso.nome
                                                    FROM nome_corso
                                                    INNER JOIN corso ON nome_corso.nome = corso.nome_id
                                                    ORDER BY corso.id;";

                                            if ($result = mysqli_query($link, $sql)) {
                                                if (mysqli_num_rows($result) > 0) {
                                                    while ($row = mysqli_fetch_array($result)) {
                                                        $setSelect = 'selected';
                                                        if ($hh == $row['nome']) {
                                                            echo '<option value="' . $row['nome'] . '" ' . $setSelect . '  >' . $row['nome'] . '</option>';
                                                        } else {
                                                            echo '<option value="' . $row['nome'] . '">' . $row['nome'] . '</option>';
                                                        }
                                                    }
                                                    // Free result set
                                                    mysqli_free_result($result);
                                                } else {
                                                    echo '<div class="alert alert-danger"><em>Non è stato trovato nessun record.</em></div>';
                                                }
                                            } else {
                                                echo "Oops! Something went wrong. Please try again later.";
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="col">
                                        <input class="btn btn-success" type="submit" value="Invio">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <?php
                        // Include config file
                        require_once "config.php";

                        // Visualizza inscritti corso tennis
                        if (isset($_POST['formSelectUtentiFromCorso']) && !empty($_POST['formSelectUtentiFromCorso'])) {
                            $sql = "SELECT utente.*, prenotazione.data_prenotazione
                            FROM utente
                            INNER JOIN prenotazione ON utente.id = prenotazione.utente_id
                            INNER JOIN corso ON corso.id = prenotazione.corso_id
                            WHERE corso.nome_id = '$hh';";

                            if ($result = mysqli_query($link, $sql)) {
                                if (mysqli_num_rows($result) > 0) {
                                    echo '<table class="table text-nowrap table-bordered table-striped">';
                                    echo "<thead>";
                                    echo "<tr>";
                                    echo "<th>#</th>";
                                    echo "<th>Nome</th>";
                                    echo "<th>Cognome</th>";
                                    echo "<th>Data Prenotazione</th>";
                                    echo "</tr>";
                                    echo "</thead>";
                                    echo "<tbody>";
                                    while ($row = mysqli_fetch_array($result)) {
                                        echo "<tr>";
                                        echo "<td>" . $row['id'] . "</td>";
                                        echo "<td>" . $row['nome'] . "</td>";
                                        echo "<td>" . $row['cognome'] . "</td>";
                                        echo "<td>" . $row['data_prenotazione'] . "</td>";

                                        echo "</tr>";
                                    }
                                    echo "</tbody>";
                                    echo "</table>";
                                    // Free result set
                                    mysqli_free_result($result);
                                } else {
                                    echo '<div class="alert alert-danger"><em>Non è stato trovato nessun record</em></div>';
                                }
                            } else {
                                echo "Oops! Something went wrong. Please try again later.";
                            }
                        }
                        ?>
                    </div>
                </div>

                <div class="footer" style="height: 250px;"></div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->
</body>

</html>