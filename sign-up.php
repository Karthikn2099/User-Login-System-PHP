<?php
    include 'DATABASE/DB_CONNECTION_ENABLE.php';
      // function to check the input data
      function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }

      //Listening for the submit event...
      if(isset($_POST['submit'])) {
        // after form validation
        if (validateUserForm()) {
          $user_name = test_input($_POST['user-name']);
          $user_username = test_input($_POST["user-username"]);
          $user_email = $_POST["user-email"];
          $user_password = $_POST["user-password"];

            //to insert user data to the users_table
            //checking if the user already exists or not
            $select_username_query = "SELECT * FROM users_table WHERE USER_NAME='$user_username'";
            $select_username_result = mysqli_query( $connect , $select_username_query );

            $select_email_query = "SELECT * FROM users_table WHERE EMAIL='$user_email'";
            $select_email_result = mysqli_query( $connect , $select_email_query );

            if( mysqli_num_rows($select_username_result) > 0 ) {
              echo "<script>alert('User Already taken');</script>";
              header('Location: sign-up.php');
            }
            else if( mysqli_num_rows($select_email_result) == 1 ) {
              echo "<script>alert('Email Id already taken');</script>";
              header('Location: sign-up.php');
            }
            else {
              $insert_query = "INSERT INTO users_table(NAME , USER_NAME , EMAIL , PASSWORD ) VALUES( '$user_name' , '$user_username' , '$user_email' , '$user_password' );";
              mysqli_query( $connect , $insert_query );
              sleep(1);
              header('Location: index.php');
            }

        }

    }




    // PHP Function to validate form when it been submitted
    function validateUserForm() {
        if($_SERVER["REQUEST_METHOD"] === "POST") {

          if( empty($_POST["user-name"]) || empty($_POST["user-username"]) || empty($_POST["user-email"]) || empty($_POST["user-password"]) ) {
            echo "<script>alert('Fill all the fields');</script>";
            return false;
          }

          if ( !ctype_alnum($_POST['user-name']) ) {
            echo "<script>alert('firstname is not valid.');</script>";
            return false;
          }

          if ( !ctype_alnum($_POST['user-username']) ) {
            echo "<script>alert('firstname is not valid.');</script>";
            return false;
          }


          if ( !filter_var($_POST['user-email'] , FILTER_VALIDATE_EMAIL) ) {
            echo "<script>alert('Email is not valid.');</script>";
            return false;
          }

          if( $_POST['user-password'] !== $_POST['user-confirm-password'] ) {
            echo "<script>alert('Password is not same');</script>";
            return false;
          }
          return true;
      }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Login System</title>
  <link rel="stylesheet" href="main.css" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css?family=Lalezar" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous" />
  <link href="https://fonts.googleapis.com/css?family=Paytone+One" rel="stylesheet">
</head>
<body>

  <div id="sign-up-form">
    <div class="sign-up-header">
      User SignUp Form
    </div>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

        <div class="form-group">
          <label for="name">Name:</label>
          <input id="name" name="user-name" type="text" class="form-control" />
        </div>

        <div class="form-group">
          <label for="username">User Name:</label>
          <input id="username" name="user-username" type="text" class="form-control" />
        </div>

        <div class="form-group">
          <label for="email">Email:</label>
          <input id="email" name="user-email" type="email" class="form-control" />
        </div>

        <div class="form-group">
          <label for="password">Password:</label>
          <input id="password" name="user-password" type="password" class="form-control" />
        </div>

        <div class="form-group">
          <label for="password">Confirm Password:</label>
          <input id="password" name="user-confirm-password" type="password" class="form-control" />
        </div>

        <input type="submit" class="btn btn-primary" value="Sign Up" name="submit"/>
        <input type="reset" class="btn btn-success" value="Reset" name="reset"/>
    </form>
    <div class="sign-up" style="font-size:17px;margin:10px auto auto 80px;">
      Have an account? <a href="sign-in.php">Sign In</a> here.
    </div>
  </div>
</body>
</html>


<?php
      include_once 'DATABASE/DB_CONNECTION_DISABLE.php';
 ?>
