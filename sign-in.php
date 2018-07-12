<?php
    include 'DATABASE/DB_CONNECTION_ENABLE.php';
    session_start();

    if( isset($_POST['login']) ) {

        if( empty($_POST["signin-email"]) || empty($_POST["signin-password"]) ) {
          echo "<script>alert('Please Fill all the fields');</script>";
        }

        $user_email = $_POST['signin-email'];
        $user_password = $_POST['signin-password'];
        //for ADMIN
        if( $user_email == "ADMIN@gmail.com" && $user_password == "ADMIN"  ) {
          sleep(1);
          header('Location: ADMIN/admin.php');
        }

        //for normal users
        $check_user_query = "SELECT * FROM users_table WHERE EMAIL='$user_email'";
        $check_user_result = mysqli_query( $connect , $check_user_query );

        if( mysqli_num_rows($check_user_result) == 0 ) {
          echo "<script>alert('Invalid User Please sign up');</script>";
          header('Location: sign-up.php');
        }
        else {
            $row = mysqli_fetch_assoc( $check_user_result );

            if ( $user_password == $row['PASSWORD']   ) {

                $_SESSION['NAME'] = $row['NAME'];
                $_SESSION['USER_NAME'] = $row['USER_NAME'];
                $_SESSION['EMAIL'] = $row['EMAIL'];
                sleep(1);
                header('Location: USER/user-profile.php');
            }
            else {
              echo "<script>alert('Invalid password');</script>";
            }

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

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

      <div id="sign-up-form" style="width:35%">
        <div class="sign-up-header">
          User SignIn Form
        </div>

        <div class="form-group">
          <label for="signin-email">Email:</label>
          <input id="signin-email" name="signin-email" type="text" class="form-control" />
        </div>
        <div class="form-group">
          <label for="signin-password">Password:</label>
          <input id="signin-password" name="signin-password" type="password" class="form-control" />
        </div>

        <input type="submit" class="btn btn-success" name="login" value="Log In" />
    </form>
    <div class="sign-up" style="font-size:17px;margin:10px auto auto 80px;">
      Do not have account? <a href="sign-up.php">sign up</a> here.
    </div>
  </div>

</body>
</html>

<?php
    include_once 'DATABASE/DB_CONNECTION_DISABLE.php';
?>
