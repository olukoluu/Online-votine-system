<?php
ob_start();
include_once('includes/connect.php');
session_start();

$id = $_SESSION['id'];
$matric_no = $_SESSION['matric_no'];


if ($_SESSION['verified'] === true) {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="asset/style.css" />
        <link rel="stylesheet" href="asset/bootstrap/css/bootstrap.min.css" />
        <script defer src="asset/bootstrap/js/bootstrap.bundle.min.js"></script>
        <title>Voters Dashboard</title>
    </head>

    <body class=" position-relative" style="background-color: #00000f; color: #f5f5f5;">

        <div class="border-bottom mt-4">
            <div class="container d-flex justify-content-between align-items-center ">
                <div class="">
                    <h4>Student Portal</h4>
                    <p class=" small text-opacity-75">Welcome, <?= $matric_no ?></p>
                </div>
                <button class="btn border btn-outline-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    <img src="asset/images/signoutt.png" alt="vote" style="width: 25px;"> Sign Out
                </button>
            </div>
        </div>
        <main class=" container pt-4 w-100">
            <h3>Available Elections</h3>

            <?php
            $sql = "SELECT * FROM elections WHERE status = 'active'";
            // $stmt = $conn->prepare($sql);
            // $stmt->execute();
            // $result = $stmt->get_result();
            $stmt = mysqli_query($conn, $sql);
            $hasRows = false;
            while ($row = mysqli_fetch_assoc($stmt)) {
                $hasRows = true;
            ?>
                <section class=" container d-flex justify-content-between align-items-center mt-4 p-3 border rounded-2 bg-dark w-100">
                    <div class="">
                        <h5 class=" fw-bold mb-1 d-flex align-items-center"><?= $row['title'] ?></h5>
                        <p class="small"><?= $row['description'] ?></p>
                        <?php
                        $psql = "SELECT * FROM positions WHERE election_id = ? ORDER BY id";
                        $pstmt = $conn->prepare($psql);
                        $pstmt->bind_param('i', $row['id']);
                        $pstmt->execute();
                        $presult = $pstmt->get_result();
                        $positionCount = $presult->num_rows;
                        ?>
                        <p class=" mb-0"><?= $positionCount ?> position(s)</p>
                        <p class=" d-inline-block m-2 ms-0">Start: <?= date('d/m/y', strtotime($row['start_date'])) ?></p>
                        <p class=" d-inline-block m-2 ms-0">End: <?= date('d/m/y', strtotime($row['end_date'])) ?></p>
                    </div>
                    <?php
                    $checksql = "SELECT 1 FROM votes WHERE election_id = ? AND voter_id = ?";
                    $checkstmt = $conn->prepare($checksql);
                    $checkstmt->bind_param('ii', $row['id'], $id);
                    $checkstmt->execute();
                    $presult = $checkstmt->get_result();
                    if ($presult->num_rows) {
                        echo '<button class=" btn border" disabled="disabled">Already Voted</button>';
                    } else {
                        echo '
                    <form method="GET" action="voting.php">
                        <input type="hidden" name="election_id" value="' . $row["id"] . '">
                        <input type="hidden" name="election_title" value="' . $row["title"] . '">
                        <input type="hidden" name="election_description" value="' . $row["description"] . '">
                        <button name="vote" type="submit" class="btn btn-success"><img src="asset/images/vote.png" alt="vote" style="width: 25px;"> Vote</button>
                    </form>';
                    }
                    ?>
                </section>
            <?php }
            if (!$hasRows) {
                echo '<tr><td colspan="3"><h3 class="text-center my-4">NO AVAILALBLE ELECTION</h3></td></tr>';
            }
            ?>
        </main>
    </body>

    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel"><i class="fa-solid fa-triangle-exclamation"></i>Confirm sign out </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h4>Are you sure you want to sign out of your account?</h4>
                </div>
                <div class="modal-footer">
                    <a href="includes/logout.php" class="btn btn-secondary">Sign Out</a>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal"> Cancel!</button>
                </div>
            </div>
        </div>
    </div>

    </html>
<?php
    mysqli_close($conn);
} else {
    header("Location: login.php");
}
?>