<html >
<meta charset=utf-8/>
<body>
<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
 
// Include config file
require_once "config.php";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
        // Prepare a select statement
        $sql = "SELECT * FROM infos WHERE id = ?";        

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_nome, $param_email);
            
            // Set parameters
            $param_nome = $nome;
            $param_email = $email;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $email, $nome, $va_senha);
                    if(mysqli_stmt_fetch($stmt)){
                           echo "bateu aqui <br>";
                           echo $senha." - ".$email." ".$va_senha;
                        if(password_verify($senha, $va_senha)){
                            // Password is correct, so start a new session
                            session_start();
                            echo "Validou";
                            echo "<h2>Tem certeza que deseja excluir o seguinte usuário?</h2>";
                            echo "Nome: ".$nome." e-mail: ".$email." senha: ".$va_senha;
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["email"] = $email;                            
                            $_SESSION["nome"] = $nome;
   
                            // Redirect user to welcome page
                            header("location: welcome.php");
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Senha errada.";
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
    
    // Close connection
    mysqli_close($link);
?>    

</body>
</html>