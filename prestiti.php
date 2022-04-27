<?php
	session_start();

    $titolo = "";

    include 'db_connection.php';
    //prelevo i dati dalla tabella
    $query = "SELECT * FROM libro WHERE id = '".$_GET['id-libro']."'";

    $risultato = $GLOBALS['conn']->query($query);

    if ($risultato->num_rows > 0) {

        // salvo le informazioni dell'utente
        while($riga = $risultato->fetch_assoc()) {
            $titolo = $riga["titolo"];
        }
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="style/prestiti.css">
        
        <title>Prestiti</title>
    </head>
    <body>

        <h1>Prestito per il libro:</h1>
        <h2><?php echo $titolo; ?></h2>

        <form method="post">

            <label for="utenti"><b>Utente</b></label>
            <?php
                //prelevo i dati dalla tabella
                $query = "SELECT * FROM utenti";

                $risultato = $conn->query($query);

                if ($risultato->num_rows > 0) {
                    echo "<select name='utenti'' id='utenti'>";
                    // salvo le informazioni dell'utente
                    while($riga = $risultato->fetch_assoc()) {
                        echo "<option value='".$riga["id"]."'>".$riga["nome"]." ".$riga["cognome"]."</option>";
                    }
                    echo "</select>
                    <br><br>";
                }
            ?>

            <label for="dataInizio"><b>Data inizio</b></label>
            <input type="date" name="dataInizio" required><br>
            <label for="dataFine"><b>Data fine</b></label>
            <input type="date" name="dataFine" required><br><br>

            <button type="submit" name="presta">Presta</button>

        </form>

    </body>
</html>


<?php
    
    if(array_key_exists('presta', $_POST)) {
        
        $id_utente = $_POST['utenti'];
        $data_inizio = $_POST['dataInizio'];
        $data_fine = $_POST['dataFine'];
        
        $sql = "INSERT INTO prestito (id_utente, data_inizio, data_fine) VALUES ('$id_utente', '$data_inizio', '$data_fine')";

        if ($conn->query($sql) === TRUE) {
        	$id_prestito = mysqli_insert_id($conn);
            
            $sql = "UPDATE libro SET id_prestito = '".$id_prestito."' WHERE id = '".$_GET['id-libro']."'";

            if ($conn->query($sql) === TRUE) {
                echo "prestito confermato";
                header("Location: catalogo.php"); 
            }
            else {
                echo "Error updating record: " . $conn->error;
            }
        }
        else {
            echo "Errore nell'inserimento";
        }
        
         
        
    }
		
?>