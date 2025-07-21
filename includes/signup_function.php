<?php

function is_input_empty($fname, $lname, $email, $matric_no, $pwd, $conPwd)
{
    if (empty($fname) || empty($lname) || empty($email) || empty($matric_no) || empty($pwd) || empty($conPwd)) {
        return true;
    } else {
        return false;
    }
}

function is_password_same($pass, $cpass)
{
        if ($pass == $cpass) {
            return true;
        } else{
            return false;
        }
}

function is_email_invalid($email)
{
    if(!empty($email)){
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }
}

//query the db to get email
function get_email($conn, $email)
{
    $sql = "SELECT * FROM voters WHERE email LIKE '$email%'";
        $stmt = mysqli_query($conn,$sql);
        $row = mysqli_fetch_assoc( $stmt );
        // $count = mysqli_num_rows( $stmt );
        return $row;
}

function is_email_taken($conn, $email)
{
    if(!empty($email)){
        if (get_email($conn, $email)) {
            return true;
        } else {
            return false;
        }
    }
}

//query the db to get matric_no
function get_matric_no($conn, $matric_no)
{
    $sql = "SELECT * FROM voters WHERE matric_no LIKE '$matric_no%'";
        $stmt = mysqli_query($conn,$sql);
        $row = mysqli_fetch_assoc( $stmt );
        // $count = mysqli_num_rows( $stmt );
        return $row;
}

function is_matric_no_taken($conn, $matric_no)
{
    if(!empty($matric_no)){
        if (get_matric_no($conn, $matric_no)) {
            return true;
        } else {
            return false;
        }
    }
}


// To display error msg
function check_signup_errors()
{
    if (isset($_SESSION['errors_signup'])) {
        $errors = $_SESSION['errors_signup'];
        echo "<br>";

        foreach ($errors as $error) {
            echo '<p style="color: red">' . $error . '</p>';
        }

        unset($_SESSION['errors_signup']);
    }
}

