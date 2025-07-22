<?php
session_start();

include_once('connect.php');
include_once('login_function.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {


    $matric_no = $_POST['matric_no'];
    $pass = $_POST['pass'];
    $verified = false;

    $errors = [];

    if (is_input_empty($matric_no, $pass)) {
        $errors["input_empty"] = "Fill all fields!";
    }
    if (does_matric_no_exist($conn, $matric_no)) {
        $errors["matric_no_exist"] = "matric no doesnot exist!";
    }

    if ($errors) {
        $_SESSION['errors_login'] = $errors;
        header("Location: ../login.php");
        die();
    }

    $sql = "SELECT * FROM voters WHERE matric_number LIKE '$matric_no%'";
    $stmt = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($stmt);
    $count = mysqli_num_rows($stmt);

    if ($count == 1) {
        $hashed_password = $row['pwd'];
        $verify = password_verify($pass, $hashed_password);
        if ($verify) {
            $verified = true;
            session_start();
            $_SESSION['id'] = $row["id"];
            $_SESSION['FName'] = $row["first_name"];
            $_SESSION['LName'] = $row["last_name"];
            $_SESSION['Email'] = $row["email"];
            $_SESSION['matric_no'] = $row["matric_number"];
            $_SESSION['is_admin'] = $row["is_admin"];
            $_SESSION['verified'] = $verified;

            if ($row["is_admin"] == 1) {
                header('Location: ../admin/dashboard.php');
            } else {
                header('Location: ../dashboard.php');
            }

            exit();
        } else {
            $_SESSION['errors_login']["pwd_invalid"] = "Incorrect Password!";
            header('Location: ../login.php');
        }
    }
}

mysqli_close($conn);
