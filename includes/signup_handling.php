<?php
session_start();
include_once('connect.php');
include_once('signup_function.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $matric_no = $_POST['matric_no'];
    $pass = $_POST['pass'];
    $cpass = $_POST['cpass'];

    $errors = [];

    if (is_input_empty($fname, $lname, $email, $matric_no, $pass, $cpass)) {
        $errors["input_empty"] = "Fill all fields!";
    }
    if (!is_password_same($pass, $cpass)) {
        $errors["password_different"] = "Password not the same!";
    }
    if (is_email_invalid($email)) {
        $errors["email_invalid"] = "Invalid Email!";
    }
    if (is_email_taken($conn, $email)) {
        $errors["email_taken"] = "Email already exist!";
    }
    if (is_matric_no_taken($conn, $matric_no)) {
        $errors["matric_no_taken"] = "Matric no already exist!";
    }

    if ($errors) {
        $_SESSION['errors_signup'] = $errors;
        header("Location: ../signup.php");
        die();
    }


    $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
    $sql = "INSERT INTO voters (first_name, last_name, email, matric_number, pwd) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssis", $fname, $lname, $email, $matric_no, $hashed_password);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: ../login.php");
        mysqli_stmt_close($stmt);
        die();
    } else {
        echo "Error executing the query: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
