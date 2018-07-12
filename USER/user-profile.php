<?php

  // connecting to the database
  include_once '../DATABASE/DB_CONNECTION_ENABLE.php';

  session_start();
  $name = $_SESSION['NAME'];
  $username = $_SESSION['USER_NAME'];
  $email = $_SESSION['EMAIL'];

  if( isset($_POST['logout'])  ) {
    session_unset();
    session_destroy();
    sleep(1);
    header('Location: ../index.php');
  }

  // listening for book-room submit event
  if( isset($_POST['book-room']) ) {
    $check_in_date = $_POST['check-in-date'];
    $check_out_date = $_POST['check-out-date'];
    $no_of_people = $_POST['no-of-people'];
    $no_of_rooms = $_POST['no-of-rooms'];
    $room_type = $_POST['room-type'];
    $phone = $_POST['phone'];

    if( empty($check_in_date) || empty($check_out_date) || empty($no_of_people) || empty($no_of_rooms) || empty($room_type) || empty($phone) ) {
      echo "<script>alert('Please fill in all the fields');</script>";
      header('Location: user-profile.php');
    }
    else {

      $insert_user_details_query = "INSERT INTO reserved_rooms_table(NAME ,	EMAIL ,	PHONE ,	CHECK_IN_DATE ,	CHECK_OUT_DATE , NO_OF_PEOPLE ,	NO_OF_ROOMS ,	ROOM_TYPE) VALUES( '$name' , '$email' , '$phone' , '$check_in_date' , '$check_out_date' , '$no_of_people' , '$no_of_rooms' , '$room_type' );";
      $insert_user_details_result = mysqli_query( $connect , $insert_user_details_query );

      if( $insert_user_details_result ) {
        sleep(1);
        header('Location: user-profile.php');
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
  <link rel="stylesheet" href="user-profile.css" type="text/css"/>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css?family=Lalezar" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous" />
  <link href="https://fonts.googleapis.com/css?family=Paytone+One" rel="stylesheet">
</head>
<body onload="openUserTab(event , 'book-room')" >

  <div id="header">
    <header>
      <div id='log-out'>
          <div class="username">
            Hey &nbsp;<?php echo $name; ?>
          </div>
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" >
            <input type="submit" name="logout" value="Log Out" class="btn btn-success"/>
          </form>
      </div>
    </header>
  </div>

</body>
</html>


<?php
    // disconnecting from the database
    include '../DATABASE/DB_CONNECTION_DISABLE.php';
 ?>
