<?php


// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$email= $senha = $confirm_senha = "";
$email_err = $senha_err = $confirm_senha_err = "";


if($_SERVER["REQUEST_METHOD"] == "POST"){



//-------------------------------------------------------------------------------
 // Validate email
if(empty(trim($_POST["email"]))){
        $email_err = "Please enter a username.";
} elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["email"]))){
        $email_err = "E-mail can only contain letters, numbers, and underscores.";
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

                    echo "<br> email ja utilizado";

                } else{
                    $email = trim($_POST["email"]);

                    // Testando funcionalidade
                    echo "<br>email deu certo";



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
        
        // Testando funcionalidade
        echo "<br>Senha em branco";

    } elseif(strlen(trim($_POST["senha"])) < 6){
        $senha_err = "Password must have atleast 6 characters.";
        // Testando funcionalidade
        echo "<br>Senha curta";

    } else{
        $senha = trim($_POST["senha"]);
        // Testando funcionalidade
        echo "<br><br>Senha 1 OK";

    }

// Validate confirm password
    if(empty(trim($_POST["confirm_senha"]))){
        $confirm_senha_err = "Please confirm password."; 
        // Testando funcionalidade
        echo "<br><br>Confirme a senha";

    } else{
        $confirm_senha = trim($_POST["confirm_senha"]);
        if(empty($senha_err) && ($senha != $confirm_senha)){
            $confirm_senha_err = "Password did not match.";

            // Testando funcionalidade
        echo "<br><br>senhas nao coincidem";
        }
        
        else {
            // Testando funcionalidade
            echo "<br><br>senhas coincidem";
        }
    }


    //------------------------------------------------------------------------------------


    // Check input errors before inserting in database
    if(empty($email_err) && empty($senha_err) && empty($confirm_senha_err)){
        
        $primeironome = $_POST['primeironome'];
        $ultimonome = $_POST['ultimonome'];

        // Prepare an insert statement
        $sql = "INSERT INTO infos (email, senha) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_email, $param_senha);
            
            // Set parameters
            $param_email = $email;
            $param_senha = $senha;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){

            // Testando funcionalidade
            echo "<br>TUDO CERTO";

            $primeironome = $_POST['primeironome'];
            $ultimonome = $_POST['ultimonome'];
            $aniversario = $_POST['aniversario'];

            $sql2 = "UPDATE  infos SET primeironome='$primeironome', ultimonome='$ultimonome', aniversario='$aniversario' WHERE email= '$email' ";

              if (mysqli_query($link, $sql2)) {
  echo "New record created successfully";
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

    // Testando funcionalidade
    echo "<br>Link fechado";

    //-----------------------------------------------------------------------------------------------------

}





/*

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