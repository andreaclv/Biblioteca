<?php
		session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="style/index.css">
        
        <title>Autenticazione</title>
    </head>
<body>

<h1 >Library</h1>

<form method="post">
  <div class="imgcontainer">
    <img src="img/logo.svg" alt="Avatar" class="logo">
  </div>

  <div class="container">
    <label for="uname"><b>Email</b></label>
    <input type="text" placeholder="Enter Username" name="email" required>
    
    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="password" required>
        
    <button type="submit" name="login">Login</button>
    <label>
      <input type="checkbox" checked="checked" name="remember"> Remember me
    </label>
  </div>

  <div class="container" style="background-color:#f1f1f1">
    <button type="reset" class="cancelbtn">Cancel</button>
    <span class="psw"><a href="register.php">register</a></span>
  </div>
</form>

</body>
</html>


<?php
        
		$login_email = "";
		$login_password = "";
        $db_id = [];
        $db_nome = [];
		$db_password = [];
		$db_email = [];
        $db_cognome = [];
		$no = 1;
		
	
		include 'db_connection.php';
        
//______________________AUTENTICAZIONE_______________________________
		if(array_key_exists('login', $_POST)) {
            if (isset($_POST['email'])) {
                $login_email = htmlentities($_POST['email']);
            }
            if (isset($_POST['password'])) {
                $login_password = htmlentities($_POST['password']);
            }

            //prelevo i dati dalla tabella
            $getutente = "SELECT * FROM utenti WHERE email = '".$login_email."' AND password = '".$login_password."' AND admin = 1";
            
            $risultato = $conn->query($getutente);
            
            if ($risultato->num_rows > 0) {
                
                // salvo le informazioni dell'utente
                while($riga = $risultato->fetch_assoc()) {
                    var_dump($risultato);
                    $db_id = $riga["id"];
                    $db_nome = $riga["nome"];
                    $db_cognome = $riga["cognome"];
                    $db_email =  $riga["email"];
                    $db_password =  $riga["password"];
                    
                    header("Location: catalogo.php");  
                }
            }
            else{
                echo "controlla le tue credenziali o verifica di essere admin, questa piattaforma è privata e accessibile solo dai dipendenti della biblioteca";
            }
        }
	?>