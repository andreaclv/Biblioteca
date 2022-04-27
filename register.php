<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="style/index.css">
        
        <title>register</title>
    </head>
<body>

<h2>Biblioteca</h2>

<form method="post">
  

  <div class="container">
    <label for="nome"><b>nome</b></label>
    <input type="text" placeholder="Enter name" name="nome" required>

    <label for="cognome"><b>cognome</b></label>
    <input type="password" placeholder="Enter surname" name="cognome" required>
      
    <label for="email"><b>Email</b></label>
    <input type="text" placeholder="Enter email" name="email" required>

    <label for="password"><b>Password</b></label>
    <input type="password" placeholder="Enter password" name="password" required>
        
    <button type="submit" name="register">register</button>

  </div>

  <div class="container" style="background-color:#f1f1f1">
    <button type="button" class="cancelbtn">Cancel</button>
    <span class="psw"><a href="index.php">login</a></span>
  </div>
</form>

</body>
</html>
