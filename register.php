<?php


// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$email= $senha = $confirm_senha = $aniversario = "";
$email_err = $senha_err = $confirm_senha_err = $aniversario_err = "";
$confirm = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

$tmail = trim($_POST["email"]);



//Validar Aniversario

if(empty(trim($_POST["aniversario"]))){

$aniversario_err ="Favor insira sua data de nascimento";

} 


//-------------------------------------------------------------------------------
 // Validate email
if(empty(trim($_POST["email"]))){
        $email_err = "Please enter an e-mail.";
} elseif(!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)){
        $email_err = "Formato invalido: $tmail";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM infos WHERE email = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            // Set parameters
            $param_email = trim($_POST["email"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";


                } else{
                    $email = trim($_POST["email"]);

                    
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
        }

        //--------------------------------------------------------------------------------

 // Validate password
 if(empty(trim($_POST["senha"]))){
        $senha_err = "Please enter a password."; 


    } elseif(strlen(trim($_POST["senha"])) < 6){
        $senha_err = "Password must have atleast 6 characters.";
     

    } else{
        $senha = trim($_POST["senha"]);
    
    }

// Validate confirm password
    if(empty(trim($_POST["confirm_senha"]))){
        $confirm_senha_err = "Please confirm password."; 


    } else{
        $confirm_senha = trim($_POST["confirm_senha"]);
        if(empty($senha_err) && ($senha != $confirm_senha)){
            $confirm_senha_err = "Password did not match.";

        }
        

    }


    //------------------------------------------------------------------------------------


    // Check input errors before inserting in database
    if(empty($email_err) && empty($senha_err) && empty($confirm_senha_err) && empty($aniversario_err)){
        
        $primeironome = $_POST['primeironome'];
        $ultimonome = $_POST['ultimonome'];
        $aniversario = $_POST['aniversario'];
        $primeironome = $_POST['primeironome'];
        $ultimonome = $_POST['ultimonome'];

        // Prepare an insert statement
        $sql = "INSERT INTO infos (email, senha) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_email, $param_senha);
            
            // Set parameters
            $param_email = $email;
            $param_senha = password_hash($senha, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){


            $sql2 = "UPDATE  infos SET primeironome='$primeironome', ultimonome='$ultimonome', aniversario='$aniversario' WHERE email= '$email' ";

              if (mysqli_query($link, $sql2)) {
  $confirm = "New record created successfully";
} else {
  echo "<br>nao inserido: " . $sql2 . "<br>" . mysqli_error($link);
}
 
              // Redirect to login page
              /* header("location: login.php"); */
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);


    //-----------------------------------------------------------------------------------------------------

}





/* Nao utilizado

// database connection code
// $con = mysqli_connect('localhost', 'root', '','db_form');

$con = mysqli_connect('localhost', 'root', '','db_form');


// get the post records
$email = $_POST['email'];
$primeironome = $_POST['primeironome'];
$ultimonome = $_POST['ultimonome'];
$aniversario = $_POST['aniversario'];
$senha = $_POST['senha'];

// database insert SQL code
$sql = "INSERT INTO infos (email, senha, primeironome, ultimonome, aniversario) VALUES ('$email','$senha', '$primeironome', '$ultimonome', '$aniversario')";

if (mysqli_query($con, $sql)) {
  echo "New record created successfully";
} else {
  echo "nao inserido: " . $sql . "<br>" . mysqli_error($con);
}

// insert in database 
$rs = mysqli_query($con, $sql);

if($rs)
{
	echo "Contact Records Inserted";
}


if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();

}

*/
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Contact Form - PHP/MySQL Demo Code</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

   

</head>

<body>

    <legend>Contact Form</legend>
    <form name="frmContact" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <p>
            <label for="email">E-mail<br /></label>
            <input type="text" name="email" id="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
            <span class="invalid-feedback"><?php echo $email_err; ?></span>
        </p>
        <p>
            <label for="senha">Senha<br /></label>
            <input type="text" name="senha" class="form-control <?php echo (!empty($senha_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $senha; ?>">
                <span class="invalid-feedback"><?php echo $senha_err; ?></span>
        </p>
        <p>
            <label for="confirm_senha">Confirme Senha<br /></label>
            <input type="text" name="confirm_senha"  class="form-control <?php echo (!empty($confirm_senha_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_senha; ?>">
                <span class="invalid-feedback"><?php echo $confirm_senha_err; ?></span>
        </p>
        <p>
            <label for="Nome">Nome<br /></label>
            <input type="text" name="primeironome" id="primeironome">
        </p>
        <p>
            <label for="Sobrenome">Ultimo nome<br /></label>
            <input type="text" name="ultimonome" id="ultimonome">
        </p>
        <p>
            <label for="Aniversario">Nascimento<br /></label>
            <input type="date" name="aniversario" class="form-control <?php echo (!empty($aniversario_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $aniversario; ?>">
                <span class="invalid-feedback"><?php echo $aniversario_err; ?></span>
        </p>

        <p>
            
        </p>
        <p>
            <input type="submit" name="Submit" id="Submit" value="Enviar">
        </p>
        <p>Already have an account? <a href="login.php">Login here</a>.</p>
    </form>

</body>
</html>