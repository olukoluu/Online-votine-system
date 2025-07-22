<?php
ob_start();
include_once('includes/connect.php');
session_start();


// print_r($_POST);


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
                    <h4><?= $_GET['election_title'] ?></h4>
                    <p class=" small text-opacity-75"><?= $_GET['election_description'] ?></p>
                </div>
                <button class="btn border btn-outline-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    <img src="asset/images/signoutt.png" alt="vote" style="width: 25px;"> Sign Out
                </button>
            </div>
        </div>
        <main class=" container pt-4 w-100">
            <form action="<?php echo htmlentities($_SERVER['PHP_SELF']) ?>" method="post">
                <?php
                $psql = "SELECT * FROM positions WHERE election_id = ? ORDER BY id";
                $pstmt = $conn->prepare($psql);
                $pstmt->bind_param('i', $_GET['election_id']);
                $pstmt->execute();
                $presult = $pstmt->get_result();
                $positionCount = $presult->num_rows;
                while ($prow = $presult->fetch_assoc()) {
                ?>
                    <section class=" mt-4 ms-2 p-3 border rounded-2 bg-dark">
                        <h4><?= $prow['title'] ?></h4>
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
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="cand[<?= $prow['id'] ?>]" value="<?= $crow['id'] ?>" id="<?= $crow['id'] ?>">
                                    <label class="form-check-label" for="<?= $crow['id'] ?>">
                                        <?= $crow['name'] ?>
                                    </label>
                                </div>
                            <?php }
                            $cstmt->close();
                            ?>
                        </div>
                    </section>
<!-- SELECT 
    c.name AS candidate_name,
    p.title AS position_title,
    e.title AS election_title,
    COUNT(v.id) AS vote_count
FROM candidates c
JOIN positions p ON c.position_id = p.id
JOIN elections e ON p.election_id = e.id
LEFT JOIN votes v ON v.candidate_id = c.id
GROUP BY c.id
ORDER BY e.id, p.id, vote_count DESC; -->
                <?php }
                $pstmt->close();
                ?>
                    <input type="hidden" name="voter_id" value="<?= $_SESSION['id'] ?>">
                    <input type="hidden" name="election_id" value="<?= $_GET['election_id'] ?>">

                <button type="submit" name="submit_vote" class=" d-block mt-3 ms-auto btn btn-primary">Submit Vote</button>
            </form>
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
    if (isset($_POST['submit_vote'])) {
        $voter_id = $_POST['voter_id'];
        $election_id = $_POST['election_id'];
        $votes = $_POST['cand'];
        $sql = "INSERT INTO votes (voter_id, election_id, position_id, candidate_id) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        foreach ($votes as $position_id => $candidate_id) {
            $stmt->bind_param("iiii", $voter_id, $election_id, $position_id, $candidate_id);
            $stmt->execute();
        }
        header('Location: dashboard.php');
        die();
    }
    mysqli_close($conn);
} else {
    header("Location: login.php");
}
?>