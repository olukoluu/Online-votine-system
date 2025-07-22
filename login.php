<?php
session_start();

$errors = isset($_SESSION['errors_login']) ? $_SESSION['errors_login'] : [];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="asset/style.css" />
    <link rel="stylesheet" href="asset/bootstrap/css/bootstrap.min.css" />
    <script defer src="asset/bootstrap/js/bootstrap.bundle.min.js"></script>
    <title>Login</title>
</head>

<body class="background-form">
    <div class="form-wrap d-flex flex-column justify-content-center align-items-center gap-5 text-white fw-bold">
        <form action="./includes/login_handling.php" method="post" class=" w-75">
            <div class="mb-3">
                <label for="InputNumber" class="form-label">Matric Number</label>
                <input type="number" class="form-control" name="matric_no" id="InputNumber" aria-describedby="emailHelp">
            </div>
                <?php  if(isset($errors["matric_no_exist"])) { echo '<p style="color: red;">'.$errors["matric_no_exist"].'</p>'; }  ?>
            <div class="mb-3">
                <label for="InputPassword" class="form-label">Password</label>
                <input type="password" class="form-control" name="pass" id="InputPassword">
            </div>
            
            <?php if(isset($errors["input_empty"])) { echo '<p style="color: red;">'.$errors["input_empty"].' </p>'; } ?>
            <button type="submit" class="btn btn-primary px-3">Submit</button>
        </form>
         <?php unset($_SESSION['errors_login']); ?>
        <p>Don't have an account? <a href="signup.php" class=" text-primary-emphasis">Sign up</a></p>
    </div>
</body>

</html>