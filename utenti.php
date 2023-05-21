<?php
$lastPath = $actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
file_put_contents('config.txt', $lastPath);
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <title>Centro Sportivo</title>
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
                            <h2 class="pull-left">Utenti</h2>
                            <a href="create/create_utente.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Aggiungi </a>
                        </div>
                        <?php
                        // Include config file
                        require_once "config.php";

                        // Visualizza utente
                        $sql = "SELECT * FROM utente;";
                        if ($result = mysqli_query($link, $sql)) {
                            if (mysqli_num_rows($result) > 0) {
                                echo '<table class="table text-nowrap table-bordered table-striped table-hover">';
                                echo "<thead>";
                                echo "<tr>";
                                echo "<th>#</th>";
                                echo "<th>Nome</th>";
                                echo "<th>Cognome</th>";
                                echo "<th>Data nascita</th>";
                                echo "<th style='width: 16px'>Corsi</th>";
                                echo "<th style='text-align: center;'>Action</th>";
                                echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while ($row = mysqli_fetch_array($result)) {
                                    echo "<tr>";
                                    echo "<td>" . $row['id'] . "</td>";
                                    echo "<td>" . $row['nome'] . "</td>";
                                    echo "<td>" . $row['cognome'] . "</td>";
                                    echo "<td>" . $row['data_nascita'] . "</td>";

                                    $idUser = $row['id'];
                                    $sqlGetCorsi = " SELECT
                                                        corso.nome_id as corso_nome
                                                    FROM utente
                                                        INNER JOIN prenotazione on prenotazione.utente_id = utente.id
                                                        INNER JOIN corso on prenotazione.corso_id = corso.id
                                                    WHERE utente_id = $idUser
                                                    ORDER BY corso_nome;";
                                    if ($listaCorsi = mysqli_query($link, $sqlGetCorsi)) {
                                        if (mysqli_num_rows($listaCorsi) > 0) {
                                            // echo "<td style='display: flex;align-items: center;justify-content: center; text-align: center;'>";
                                            echo "<td style='display: flex;align-items: center;justify-content: center; text-align: center;'>";
                                            while ($rowListaCorsi = mysqli_fetch_array($listaCorsi)) {
                                                $nomeCorso = $rowListaCorsi[0];
                                                echo "<span class='corso' style='padding-left: 0.5rem; padding-right: 0.5rem;'>$nomeCorso</span>";
                                            }
                                            echo "</td>";
                                        } else {
                                            echo "<td ></td>";
                                        }
                                    }


                                    echo "<td>";
                                    echo "<div class='d-flex justify-content-around'>";
                                    echo '<a href="update/update_utente.php?id=' . $row['id'] . '" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                    echo '<a href="delete.php?id=' . $row['id'] . '&tb=utente" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                                    echo "</div>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";
                                echo "</table>";
                                // Free result set
                                mysqli_free_result($result);
                            } else {
                                echo '<div class="alert alert-danger"><em>Nessun record è stato trovato.</em></div>';
                            }
                        } else {
                            echo "Oops! Something went wrong. Please try again later.";
                        }
                        ?>
                    </div>
                </div>

                <!-- Footer -->
                <?php
                echo file_get_contents("components/footer.php");
                ?>
                <!-- Footer -->
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->
</body>

</html>