<?php
// Include config file
require_once "./php/connect.php";
 
// Define variables and initialize with empty values
$customerName = $customerEmail = $address = $phoneNumber = $customerPassword = $confirm_customerPassword = "";
$customerName_err = $customerEmail_err = $address_err = $phoneNumber_err = $customerPassword_err = $confirm_customerPassword_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate CustomerName
    if(empty(trim($_POST["customerName"]))){
        $customerName_err = "Please enter a CustomerName.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["customerName"]))){
        $customerName_err = "CustomerName can only contain letters, numbers, and underscores.";
    } else{
        // Prepare a select statement
        $sql = "SELECT * FROM Customer WHERE customerName = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_customerName);
            
            // Set parameters
            $param_customerName = trim($_POST["customerName"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $customerName_err = "This username is already taken.";
                } else{
                    $customerName = trim($_POST["customerName"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
	// Validate accountCreationDate
	$accountCreationDate = Date( 'Y-m-d H:i:s', $phpdate );
	$$phpdate = strtotime( $mysqldate );
	
	
	// Validate customerEmail
    if(empty(trim($_POST["customerEmail"]))){
        $customerEmail_err = "Please enter a Email.";     
    } elseif(strlen(trim($_POST["customerEmail"])) < 6){
        $customerEmail_err = "Email must have atleast 6 characters.";
    } else{
        $customerEmail = trim($_POST["customerEmail"]);
    }
	
	// Validate address
    if(empty(trim($_POST["address"]))){
        $address_err = "Please enter a Address.";     
    } elseif(strlen(trim($_POST["address"])) < 6){
        $address_err = "Address must have atleast 6 characters.";
    } else{
        $address = trim($_POST["address"]);
    }
	
	// Validate phoneNumber
    if(empty(trim($_POST["phoneNumber"]))){
        $phoneNumber_err = "Please enter a PhoneNumber.";     
    } elseif(strlen(trim($_POST["phoneNumber"])) < 8){
        $phoneNumber_err = "PhoneNumber must have atleast 8 characters.";
    } else{
        $phoneNumber = trim($_POST["phoneNumber"]);
    }
	
    // Validate password
    if(empty(trim($_POST["customerPassword"]))){
        $customerPassword_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["customerPassword"])) < 6){
        $customerPassword_err = "Password must have atleast 6 characters.";
    } else{
        $customerPassword = trim($_POST["customerPassword"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_customerPassword"]))){
        $confirm_customerPassword_err = "Please confirm password.";     
    } else{
        $confirm_customerPassword = trim($_POST["confirm_customerPassword"]);
        if(empty($customerPassword_err) && ($customerPassword != $confirm_customerPassword)){
            $confirm_customerPassword_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($customerName_err) && empty($customerPassword_err) && empty($confirm_customerPassword_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (customerName, customerEmail, address, phoneNumber, customerPassword, accountCreationDate) VALUES (?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_customerName, $param_customerPassword);
            
            // Set parameters
            $param_customerName = $customerName;
            $param_customerPassword = password_hash($customerPassword, PASSWORD_DEFAULT); // Creates a customerPassword hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
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
        <link rel ="stylesheet" href= "./css/register.css">
        
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
    
        
        <div class="container">
          
        </div>
        
          <form   name="register">
            <div id="message">
              <h3>Password must contain the following list:</h3>
              <p id="many" class="invalid">A <b>both</b> password and re-type password</p>
              <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
              <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
              <p id="number" class="invalid">A <b>number</b></p>
              <p id="length" class="invalid">Minimum <b>8 characters</b></p>
          </div>
            
            <div class="container">
              
              <h1>Customer Sign Up</h1>
              
              <br>
              
              <p>Please fills all the information to create an account.</p>
              <label for="cs_name"><b>Customer Name</b></label>
              <input type="text" placeholder="Enter Username" name="customerName" required
			  value="<?php echo $customerName; ?>">
      
              <label for="cs_name"><b>Email</b></label>
              <input type="email" placeholder="Enter Email" name="customerEmail" required
			  value="<?php echo $customerEmail; ?>">
      
              <label for="cs_name"><b>Address</b></label>
              <input type="text" placeholder="Enter Address" name="address" required
			  value="<?php echo $address; ?>">
      
              <label for="cs_name"><b>Phone Number</b></label>
              <input type="tel" placeholder="Enter Phone Number" name="phoneNumber" required
			  value="<?php echo $phoneNumber; ?>">
          
              <label for="psw"><b>Password</b></label>
              <input type="password" id="psw" name="customerPassword" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required
			  value="<?php echo $customerPassword; ?>">
      
              <label for="psw-repeat"><b>Re-type Password</b></label>
              <input type="password" placeholder="Repeat Password" name="confirm_customerPassword" id="pswretype" required
			  value="<?php echo $confirm_customerPassword; ?>">
          
              <label>
                
              </label>
              
          
              <p>By creating an account you agree to our <a href="#" style="color:rgb(84, 22, 255)">Terms & Privacy</a>.</p>
              <a href="login.php">Back to login?</a>
              
                <input type="submit" class="signupbtn" onsubmit="reg()">Sign Up</button>
                
              </div>
            </div>
          </form>
          

    </body>
</html>