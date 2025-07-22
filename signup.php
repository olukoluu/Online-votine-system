<?php
session_start();

$errors = isset($_SESSION['errors_signup']) ? $_SESSION['errors_signup'] : '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="asset/style.css" />
    <link rel="stylesheet" href="asset/bootstrap/css/bootstrap.min.css" />
    <script defer src="asset/bootstrap/js/bootstrap.bundle.min.js"></script>
    <title>Sign Up</title>
</head>

<body class="background-form">
    <div class="form-wrap h-100 d-flex flex-column justify-content-center align-items-center text-white fw-bold">
        <h2 class=" mt-4">Sign Up</h2>
        <form action="includes/signup_handling.php" method="post" class=" w-75 p-3">
            <div class=" row mb-3">
                <div class=" col-6">
                    <label for="fname" class="form-label">First Name</label>
                    <input type="text" class="form-control" name="fname" id="fname">
                </div>
                <div class=" col-6">
                    <label for="lname" class="form-label">Last Name</label>
                    <input type="text" class="form-control" name="lname" id="lname">
                </div>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" id="email">
            </div>
            <?php if (isset($errors["email_invalid"])) {
                echo '<p style="color: red;">' . $errors["email_invalid"] . '</p>';
            }  ?>
            <?php if (isset($errors["email_taken"])) {
                echo '<p style="color: red;">' . $errors["email_taken"] . '</p>';
            }  ?>
            <div class="mb-3">
                <label for="matric_no" class="form-label">Matric Number</label>
                <input type="number" class="form-control" name="matric_no" id="matric_no">
            </div>
            <?php if (isset($errors["matric_no_taken"])) {
                echo '<p style="color: red;">' . $errors["matric_no_taken"] . '</p>';
            }  ?>
            <div class="mb-3">
                <label for="pass" class="form-label">Password</label>
                <input type="password" class="form-control" name="pass" id="pass">
            </div>
            <div class="mb-3">
                <label for="cpass" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" name="cpass" id="cpass">
            </div>
            <?php if (isset($errors["password_different"])) {
                echo '<p style="color: red;">' . $errors["password_different"] . '</p>';
            }  ?>

            <?php if (isset($errors["input_empty"])) {
                echo '<p class="m-0 p-0" style="color: red;">' . $errors["input_empty"] . '</p>';
            }  ?>

            <?php
            unset($_SESSION['errors_signup']);
            ?>
            <button type="submit" class="btn btn-primary px-3">Submit</button>
        </form>
        <p class=" mt-4">Already have an account? <a href="login.php" class=" text-primary-emphasis">Login</a></p>
    </div>
</body>

</html>