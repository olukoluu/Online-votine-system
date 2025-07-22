<?php
ob_start();
include_once('../includes/connect.php');
session_start();

// print_r($_POST);
if ($_SESSION['verified'] === true) {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../asset/style.css" />
        <link rel="stylesheet" href="../asset/bootstrap/css/bootstrap.min.css" />
        <script defer src="../asset/bootstrap/js/bootstrap.bundle.min.js"></script>
        <title>Candidates Management</title>
    </head>

    <body class=" position-relative d-flex" style="background-color: #00000f; color: #f5f5f5;">
        <?php
        include_once "sidenav.php";
        ?>
        <main class="p-md-4 pt-0 w-100">
            <div class="p-3 pt-md-0 d-flex justify-content-between align-items-center pb-2 border-bottom">
                <div class="">
                    <h4 class=" display-5 fs-2 fw-bold">Elections Results</h4>
                    <p>View and export election results</p>
                </div>
            </div>

            <?php
            $sql = "SELECT * FROM elections";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
            ?>
                <section class=" container mt-4 ms-2 p-3 border rounded-2 bg-dark">
                    <div class=" d-flex justify-content-between">
                        <h5 class=" fw-bold mb-1 d-flex align-items-center"><?= $row['title'] ?></h5>
                        <button class="btn btn-primary-outline"></button>
                    </div>
                    <?php
                    $psql = "SELECT * FROM positions WHERE election_id = ? ORDER BY id";
                    $pstmt = $conn->prepare($psql);
                    $pstmt->bind_param('i', $row['id']);
                    $pstmt->execute();
                    $presult = $pstmt->get_result();
                    $positionCount = $presult->num_rows; ?>
                    <p class=" mb-0"><?= $positionCount ?> position(s)</p>
                    <div class="row row-cols-3 g-3 mt-0">
                        <?php
                        while ($prow = $presult->fetch_assoc()) {
                        ?>
                            <div class="col">
                                <div class="p-3 border rounded-3 h-100">
                                    <h6><?= $prow['title'] ?></h6>
                                    <?php
                                    $csql = "SELECT * FROM candidates WHERE position_id = ? ORDER BY id";
                                    $cstmt = $conn->prepare($csql);
                                    $cstmt->bind_param('i', $prow['id']);
                                    $cstmt->execute();
                                    $cresult = $cstmt->get_result();
                                    $candidateCount = $cresult->num_rows; ?>
                                    <p class=" small"><?= $candidateCount ?> candidate(s)</p>

                                    <div class="">
                                        <?php
                                        while ($crow = $cresult->fetch_assoc()) {
                                        ?>
                                            <div class=" d-flex justify-content-between">
                                                <p class=" d-flex justify-content-between"><?= $crow['name'] ?></p>
                                                <?php
                                                $vsql = "SELECT COUNT(*) AS vote_count FROM votes WHERE candidate_id = ? AND position_id = ? AND election_id = ?";
                                                $vstmt = $conn->prepare($vsql);
                                                $vstmt->bind_param("iii", $crow['id'], $prow['id'], $row['id']);
                                                $vstmt->execute();
                                                $vresult = $vstmt->get_result();
                                                if ($vrow = $vresult->fetch_assoc()) {
                                                    echo "<p>" .$vrow['vote_count']." vote(s)</p>";
                                                }
                                                ?>
                                            </div>
                                        <?php }
                                        $cstmt->close();
                                        ?>
                                    </div>
                                </div>
                            </div>

                        <?php }
                        $pstmt->close();
                        ?>
                    </div>
                </section>
            <?php } ?>
        </main>
    </body>

    </html>
<?php
    mysqli_close($conn);
} else {
    header("Location: ../login.php");
}
?>