<?php
require "connection.php";
$error_meg = '';

//check credintials
if (isset($_POST['submit'])) {
    $password = trim($_POST['password']);
    $email = trim($_POST['email']);

        //Check email & password
    if (empty($password) || strlen($password) < 6 || empty($email)) {
        $error_meg = 'all fields are required, password can\'t be less than 6 chars';
    }else{
        $sql = "SELECT name, email, password  FROM users WHERE email=?";

        //Login
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();

            //Record exist, verify password 
            if ($stmt->num_rows == 1) {
                $stmt->bind_result($username,$emaildb,$hashedpassword);
                $stmt->fetch();
                if (!password_verify($password, $hashedpassword)) {
                    $error_meg = 'incorrect passowrd, please try again';
                 }else {
                     //Password matches, redirect to home page
                    session_start();
                    $_SESSION['loggedin'] = true;
                    header("location: home.php?name=" . $username);
                }
            }else{
                //Record isn't exist in the database
                $error_meg = 'This email is not recorded, Sign up with github';
            }
            $stmt->close();
        }
        $conn->close();
    }   
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Login Form</title>
    <!-- CSS social  -->
    <link rel="stylesheet" href="assets/bootstrap-social.css">
    <!-- Starlight CSS -->
    <link rel="stylesheet" href="assets/css/starlight.css">
</head>

<body>

    <div class="d-flex align-items-center justify-content-center bg-sl-primary ht-100v">
        <div class="login-wrapper wd-300 wd-xs-350 pd-25 pd-xs-40 bg-white">
            <div class="signin-logo tx-center tx-24 tx-bold tx-inverse">Log<span class="tx-info tx-normal">in</span></div>
            <br>
            <div class="text-danger"><?php echo $error_meg;  ?></div>
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
            
                    <input type="email" name="email" class="form-control" placeholder="Enter your email"> 
               
                    <span class="text-danger"></span>
                </div><!-- form-group -->

                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Enter your password">
                    <span class="text-danger"></span>
                </div><!-- form-group -->

                <input type="submit" name="submit" class="btn btn-info btn-block btn-github" value="submit" />
            </form>
            <div>  <a href="https://github.com/login/oauth/authorize?client_id=795ef7834bae13934590&scope=user" class="btn btn-block btn-social btn-github"><span class="fa fa-github"></span> Sign in with Github</a>
        </div>
        </div><!-- login-wrapper -->
    </div><!-- d-flex -->

    <script src="assets/lib/jquery/jquery.js"></script>
    <script src="assets/lib/popper.js/popper.js"></script>
    <script src="assets/lib/bootstrap/bootstrap.js"></script>
    <script src="https://use.fontawesome.com/b3fb3d89e0.js"></script>

</body>
</html>