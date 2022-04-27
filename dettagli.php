<?php
	session_start();

    $titolo = "";
    $id_prestito = "";

    include 'db_connection.php';
    //prelevo i dati dalla tabella
    $query = "SELECT * FROM libro WHERE id = '".$_GET['id-libro']."'";

    $risultato = $GLOBALS['conn']->query($query);

    if ($risultato->num_rows > 0) {

        // salvo le informazioni dell'utente
        while($riga = $risultato->fetch_assoc()) {
            $titolo = $riga["titolo"];
            $id_prestito = $riga["id_prestito"];
        }
    }
    
    //prelevo i dati dalla tabella
    $query = "SELECT * FROM prestito WHERE id = '$id_prestito'";

    $risultato = $conn->query($query);
    $id_utente = "";
    $data_inizio = "";
    $data_fine = "";
    if ($risultato->num_rows > 0) {
        
        // salvo le informazioni dell'utente
        while($riga = $risultato->fetch_assoc()) {
            $id_utente = $riga["id_utente"];
            $data_inizio = $riga["data_inizio"];
            $data_fine = $riga["data_fine"];
        }
    }
    //prelevo i dati dalla tabella
    $query = "SELECT * FROM utenti WHERE id = '$id_utente'";

    $risultato = $conn->query($query);
    $nome_utente = "";
    $cognome_utente = "";
    if ($risultato->num_rows > 0) {
        
        // salvo le informazioni dell'utente
        while($riga = $risultato->fetch_assoc()) {
            $nome_utente = $riga["nome"];
            $cognome_utente = $riga["cognome"];
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
        <h2><?php echo "Attualmente in possesso di: ".$nome_utente." ".$cognome_utente; ?></h2>

        <form method="post">
            
            <?php
                echo "<label for='dataInizio'><b>Data inizio</b></label>
            <input type='date' name='dataInizio' value='$data_inizio'><br>
            <label for='dataFine'><b>Data fine</b></label>
            <input type='date' name='dataFine' value='$data_fine'><br><br>";
            ?>
            
            <button type="submit" name="termina">Termina prestito</button>
            
        </form>

    </body>
</html>


<?php
    
    if(array_key_exists('termina', $_POST)) {
        
        $deleteproduct = "DELETE FROM prestito WHERE id='$id_prestito'";
        $risultato = $conn->query($deleteproduct);
        header("Location: catalogo.php"); 
    }
		
?>