<?php
session_start();
if (!isset($_SESSION['user']) || isset($_SESSION['user']) !== true) {
    header("location: index.php");
}

require "connection.php";

$error_meg = '';
$hashedpassword = '';

//check credintials
if (isset($_POST['login'])) {
    $password = trim($_POST['password']);
    $email = trim($_SESSION['email']);
    $username = trim($_SESSION['user']);
    $param_password = password_hash($password, PASSWORD_DEFAULT);


    //Check email & password 
    if (empty($password) || strlen($password) < 6 || empty($email)) {
        $error_meg = 'all fields are required, password can\'t be less than 6 chars';
    }else{
        $sql = "SELECT password FROM users WHERE email=?";

        //Login
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();

        //Record exist
        if ($stmt->num_rows == 1) {
            $error_meg = 'This email already exist, ' . '<a href="index.php">Login</a>';
        }else {
            //Record not exist
            $sql = "INSERT INTO users (name, email, password) VALUES (?,?,?)";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("sss", $username, $email, $param_password);

                if ($stmt->execute()) {
                    $_SESSION['loggedin'] = true;
                    header("location: home.php?name=" . $username);
                }
            }else {
                $error_meg = 'registeration fail, try again';
            }
        }
            $stmt->close();
    }
}
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Choose Password</title>
    <!-- CSS social  -->
    <link rel="stylesheet" href="assets/bootstrap-social.css">
    <!-- Starlight CSS -->
    <link rel="stylesheet" href="assets/css/starlight.css">
</head>

<body>

    <div class="d-flex align-items-center justify-content-center bg-sl-primary ht-100v">
        <div class="login-wrapper wd-300 wd-xs-350 pd-25 pd-xs-40 bg-white">
            <div class="signin-logo tx-center tx-24 tx-bold tx-inverse">create<span class="tx-info tx-normal">password</span></div>
            <br>
            <div class="text-danger"><?php echo $error_meg;  ?></div>
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">

                    <input type="email" name="email" class="form-control" placeholder="Enter your email" value="<?php echo $_SESSION['email']; ?>" readonly>

                    <span class="text-danger"></span>
                </div><!-- form-group -->

                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Enter your password">
                    <span class="text-danger"></span>
                </div><!-- form-group -->

                <input type="submit" name="login" class="btn btn-info btn-block btn-github" value="Log in" />
            </form>
        </div><!-- login-wrapper -->
    </div><!-- d-flex -->

    <script src="assets/lib/jquery/jquery.js"></script>
    <script src="assets/lib/popper.js/popper.js"></script>
    <script src="assets/lib/bootstrap/bootstrap.js"></script>
    <script src="https://use.fontawesome.com/b3fb3d89e0.js"></script>

</body>

</html>