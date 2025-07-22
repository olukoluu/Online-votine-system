<?php

function is_input_empty($matric_no, $pwd)
{
    if (empty($matric_no) || empty($pwd)) {
        return true;
    } else {
        return false;
    }
}

//query the db to get matric_no
function get_matric_no($conn, $matric_no)
{
    $sql = "SELECT * FROM voters WHERE matric_number LIKE '$matric_no%'";
        $stmt = mysqli_query($conn,$sql);
        $row = mysqli_fetch_row( $stmt );
        // $count = mysqli_num_rows( $stmt );
        return $row;
}

function does_matric_no_exist($conn, $matric_no)
{
    if(!empty($matric_no)){
        if (!get_matric_no($conn, $matric_no)) {
            return true;
        } else {
            return false;
        }
    }
}
