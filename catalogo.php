<?php

    session_start();
    
    if(!isset($_SESSION['user'])){
    	//header("Location: index.php");
    }
        
?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="style/catalogo.css">
        <script src="script/catalogo.js"></script>
        <title>catalogo</title>
    </head>
    <body>

        <h1>I nostri libri</h1>
        
        <form method="post">
            <button type="submit" name="addAutore">Aggiungi autore</button>
            <button type="submit" name="addGenere">Aggiungi genere</button>
            <button type="submit" name="addLibro">Aggiungi libro</button>
        </form>
        
        <table>
            <tr>
                <th>Titolo</th>
                <th>Genere</th>
                <th>Autore</th>
                <th>Disponibilità</th>
            </tr>
            <?php
                
                include 'db_connection.php';
            
                //prelevo i dati dalla tabella
                $getlibri = "SELECT * FROM libro ORDER BY titolo ASC";

                $risultato = $conn->query($getlibri);

                if ($risultato->num_rows > 0) {

                    // salvo le informazioni dell'utente
                    while($riga = $risultato->fetch_assoc()) {
                        echo "
                        <tr>
                            <td>".$riga["titolo"]."</td>
                            <td>".trovaGenere(intval($riga["genere"]))."</td>
                            <td>".trovaAutore(intval($riga["autore"]))."</td>";
                            
                            if($riga["id_prestito"]==1){
                                echo "<td><button class='available' onclick='presta(".$riga["id"].")'>presta</button></td>";
                            }
                            else{
                                echo "<td><button class='unavailable' onclick='dettagli(".$riga["id"].")'>dettagli</button></td>";
                            }
                        
                        echo "</tr>
                        ";
                    }
                }
                else{
                    echo "Non ci sono libri in catalogo";
                }
                
                function trovaAutore($id_autore){
                    $autore = "";
                    //prelevo i dati dalla tabella
                    $query = "SELECT * FROM autore WHERE id = '".$id_autore."'";

                    $risultato = $GLOBALS['conn']->query($query);

                    if ($risultato->num_rows > 0) {

                        // salvo le informazioni dell'utente
                        while($riga = $risultato->fetch_assoc()) {
                            $autore = $riga["nome"]." ".$riga["cognome"];
                        }
                    }
                    
                    return $autore;
                }
            
                function trovaGenere($id_genere){
                    $genere = "";
                    //prelevo i dati dalla tabella
                    $query = "SELECT * FROM genere WHERE id = '".$id_genere."'";

                    $risultato = $GLOBALS['conn']->query($query);

                    if ($risultato->num_rows > 0) {

                        // salvo le informazioni dell'utente
                        while($riga = $risultato->fetch_assoc()) {
                            $genere = $riga["genere"];
                        }
                    }
                    
                    return $genere;
                }
            
                if(array_key_exists('addAutore', $_POST)) {
                    echo "<form method='post'>
                    <br><label for='nome'><b>nome</b></label><br>
                    <input type='text' placeholder='Inserisci nome' name='nome' required><br><br>
                    <label for='cognome'><b>nome</b></label><br>
                    <input type='text' placeholder='Inserisci cognome' name='cognome' required><br><br>
                    <button type='submit' name='addA'>Aggiungi</button><br><br>
                    </form>
                    ";
                }
                if(array_key_exists('addA', $_POST)) {
                    
                    if (isset($_POST['nome'])) {
                        $name = htmlentities($_POST['nome']);
                    }
                    if (isset($_POST['cognome'])) {
                        $surname = htmlentities($_POST['cognome']);
                    }
                    
                    $sql = "INSERT INTO autore (nome, cognome) VALUES ('$name', '$surname')";

                    if ($conn->query($sql) === TRUE) {
                    	echo "Autore aggiunto con successo";
                    }
                    else {
                        echo "Errore nell'inserimento";
                    }
                }
            
                if(array_key_exists('addGenere', $_POST)) {
                    echo "<form method='post'>
                    <br><label for='genere'><b>nome genere</b></label><br>
                    <input type='text' placeholder='Inserisci il nome del genere' name='genere' required><br><br>
                    <button type='submit' name='addG'>Aggiungi</button><br><br>
                    </form>
                    ";
                }
                if(array_key_exists('addG', $_POST)) {
                    
                    if (isset($_POST['genere'])) {
                        $genere = htmlentities($_POST['genere']);
                    }
                    
                    $sql = "INSERT INTO genere (genere) VALUES ('$genere')";

                    if ($conn->query($sql) === TRUE) {
                    	echo "Genere aggiunto con successo";
                    }
                    else {
                        echo "Errore nell'inserimento";
                    }
                }
            
                if(array_key_exists('addLibro', $_POST)) {
                    echo "<form method='post'>
                    <br><label for='titolo'><b>Titolo</b></label><br>
                    <input type='text' placeholder='Inserisci il titolo' name='titolo' required><br><br>";
                    
                    //prelevo i dati dalla tabella
                    $query = "SELECT * FROM autore";

                    $risultato = $conn->query($query);

                    if ($risultato->num_rows > 0) {
                        echo "<label for='autori'>Autore</label>
                        <select name='autori'' id='autori'>";
                        // salvo le informazioni dell'utente
                        while($riga = $risultato->fetch_assoc()) {
                            echo "<option value='".$riga["id"]."'>".$riga["nome"]." ".$riga["cognome"]."</option>";
                        }
                        echo "</select>
                        <br><br>";
                    }
                    
                    $query = "SELECT * FROM genere";

                    $risultato = $conn->query($query);

                    if ($risultato->num_rows > 0) {
                        echo "<label for='generi'>Genere:</label>
                        <select name='generi'' id='generi'>";
                        // salvo le informazioni dell'utente
                        while($riga = $risultato->fetch_assoc()) {
                            echo "<option value='".$riga["id"]."'>".$riga["genere"]."</option>";
                        }
                        echo "</select>
                        <br><br>";
                    }
                    
                    echo "<button type='submit' name='addL'>Aggiungi</button><br><br>
                    </form>
                    ";
                }
                if(array_key_exists('addL', $_POST)) {
                    
                    if (isset($_POST['titolo'])) {
                        $titolo = htmlentities($_POST['titolo']);
                    }
                    if (isset($_POST['generi'])) {
                        $generi = htmlentities($_POST['generi']);
                    }
                    if (isset($_POST['autori'])) {
                        $autori = htmlentities($_POST['autori']);
                    }
                    
                    $sql = "INSERT INTO libro (titolo, genere, autore) VALUES ('$titolo','$generi','$autori')";

                    if ($conn->query($sql) === TRUE) {
                    	echo "libro aggiunto con successo";
                        header("Location: catalogo.php");
                    }
                    else {
                        echo "Errore nell'inserimento";
                    }
                    
                }
            ?>
        </table>
        
    </body>
</html>

