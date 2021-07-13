
<?php
// Initialize the session
session_start();
 

 
// Include connect file
require_once "./php/connect.php";
 
// customerName variables and initialize with empty values
$customerName = $customerPassword = "";
$customerName_err = $customerPassword_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if customerName is empty
    if(empty(trim($_POST["customerName"]))){
        $customerName_err = "Please enter customerName.";
    } else{
        $customerName = trim($_POST["customerName"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["customerPassword"]))){
        $customerPassword_err = "Please enter your customerPassword.";
    } else{
        $customerPassword = trim($_POST["customerPassword"]);
    }
    
    // Validate credentials
    if(empty($customerName_err) && empty($customerPassword_err)){
        // Prepare a select statement
        $sql = "SELECT customerEmail, customerName, customerPassword FROM Customer WHERE customerName = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_customerName);
            
            // Set parameters
            $param_customerName = $customerName;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if customerName exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $customerEmail, $customerName, $hashed_customerPassword);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($customerPassword, $hashed_customerPassword)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["customerEmail"] = $customerEmail;
                            $_SESSION["customerName"] = $customerName;                            
                                                       
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid CustomerName or password.";
                        }
                    }
                } else{
                    // customerName doesn't exist, display a generic error message
                    $login_err = "Invalid CustomerName or password.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang = "en" dir="ltr">
    <head>
        <meta charset = "utf-8">
        <title>EDE System</title>
        <meta name ="viewport" content="width=device-width, inital-scale=1.0">
        <link rel ="stylesheet" href= "./css/main.css">
        
        <script src ="https://code.jquery.com/jquery-3.4.1.js"></script>
        
    </head>
    <body>
        <nav>
            <label class = "logo">EDE Express</label>
        <ul>
            <li><a href ="index.html">Home</a></li>
            <li><a href ="contact.html">Contact</a></li>
            <li><a href ="About.html">About</a></li>
            <li><a href ="login.php">Login</a></li>
        </ul>>
        <label id="menubar">
          <img src = "ICON.png">
        </label>
    </nav>
    <br></br>
        
        <form>
            <div class="imgcontainer">
            </div>
            <div class="LoginSystem">
              <label for="uname"><b>Username</b></label>
              <input type="text" placeholder="Enter Username" name="customerName" class = "form-control txtuser
			  <?php echo (!empty($customerName_err)) ? 'is-invalid' : ''; ?>" id ="usernametxt" required 
			  value="<?php echo $customerName; ?>">
				
				
              <label for="psw"><b>Password</b></label>
              <input type="password" placeholder="Enter Password" name="customerPassword" class = "form-control txtpass
			  <?php echo (!empty($customerPassword_err)) ? 'is-invalid' : ''; ?>" id="passwordtxt" required
			   value="<?php echo $customerPassword; ?>">
          
              <input type="submit" value="Login">Login</button>
            </div>
            <div class="container" style="background-color:#f1f1f1">
              <span class="psw">Forgot <a href="forgot.php">password?</a>
                <a href= "register.php">/Register</a></span>
                
            </div>
          </form>
          
      <script src="Lemon.js"></script>
        
    </body>
</html>