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
        <title>Election Management</title>
    </head>

    <body class=" position-relative d-flex" style="background-color: #00000f; color: #f5f5f5;">
        <?php
        include_once "sidenav.php";
        ?>
        <main class="p-md-4 pt-0 w-100">
            <div class="p-3 pt-md-0 d-flex justify-content-between align-items-center pb-2 border-bottom">
                <div class="">
                    <h4 class=" display-5 fs-2 fw-bold">Elections Management</h4>
                    <p>Create and manage elections, positions, and candidates</p>
                </div>
                <button class="btn btn-primary rounded-3" data-bs-toggle="modal" data-bs-target="#elctionModel">Create Elections</button>
            </div>
            <?php
            $sql = "SELECT * FROM elections";
            $stmt = mysqli_query($conn, $sql);
            $hasRows = false;
            while ($row = mysqli_fetch_array($stmt)) {
                $hasRows = true;
            ?>
                <section class=" container mt-4 ms-2 p-3 border rounded-2 bg-dark">
                    <div class=" d-flex justify-content-between">
                        <div class="">
                            <h5 class=" fw-bold mb-1 d-flex align-items-center"><?= $row['title'] ?>
                                <!-- <span class="badge rounded-pill bg-primary text-capitalize fw-medium small ms-2 p-1 px-2"> <?= $row['status'] ?></span> -->
                            </h5>
                            <p class=" small"><?= $row['description'] ?></p>
                        </div>

                        <div class=" d-flex gap-3 align-items-center">
                            <div class="form-check form-switch">
                                <label class="form-check-label" for="activeSwitch<?= $row['id'] ?>">Active</label>
                                <input class="form-check-input toggle-election" type="checkbox" role="switch" id="activeSwitch<?= $row['id'] ?>" data-id="<?= $row['id']; ?>"
                                    <?= $row['status'] == 'active' ? 'checked' : ''; ?>>
                            </div>

                            <form method="POST" action="../includes/delete.php" onsubmit="return confirm('Are you sure you want to delete this election?');">
                                <input type="hidden" name="delete_election_id" value="<?= $row['id'] ?>">
                                <button type="submit" class="btn">
                                    <img src="../asset/images/delete.png" alt="position" style="width: 30px;" />
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class=" d-flex gap-2 small text-secondary">
                        <p class=" mb-0">Start: <?= date('d/m/y', strtotime($row['start_date'])) ?></p>
                        <p class=" mb-0">End: <?= date('d/m/y', strtotime($row['end_date'])) ?></p>
                        <?php
                        $psql = "SELECT * FROM positions WHERE election_id = ? ORDER BY id";
                        $pstmt = mysqli_prepare($conn, $psql);
                        $pstmt->bind_param('i', $row['id']);
                        $pstmt->execute();
                        $presult = $pstmt->get_result();
                        $positionCount = $presult->num_rows; ?>
                        <p class=" mb-0"><?= $positionCount ?> position(s)</p>
                    </div>
                    <div class="row row-cols-3 g-3 mt-0">
                        <?php
                        while ($prow = $presult->fetch_assoc()) {
                        ?>
                            <div class="col">
                                <div class="p-3 border rounded-3 h-100">
                                    <div class="d-flex justify-content-between align-items-center mb-0 pb-0">
                                        <h6><?= $prow['title'] ?></h6>
                                        <form method="POST" action="../includes/delete.php" onsubmit="return confirm('Delete this position?');">
                                            <input type="hidden" name="delete_position_id" value="<?= $prow['id'] ?>">
                                            <button type="submit" class="btn p-0">
                                                <img src="../asset/images/delete.png" alt="position" style="width: 20px;" />
                                            </button>
                                        </form>
                                    </div>
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
                                                <p class=""><?= $crow['name'] ?></p>
                                                <form method="POST" action="../includes/delete.php" onsubmit="return confirm('Delete this candidate?');">
                                                    <input type="hidden" name="delete_candidate_id" value="<?= $crow['id'] ?>">
                                                    <button type="submit" class="btn p-0">
                                                        <img src="../asset/images/delete.png" alt="position" style="width: 20px;" />
                                                    </button>
                                                </form>
                                            </div>
                                        <?php }
                                        $cstmt->close();
                                        ?>
                                    </div>

                                    <form action="<?php echo htmlentities($_SERVER['PHP_SELF']) ?>" method="post" class=" d-block mt-auto">
                                        <input type="hidden" name="position_id" id="position_id" value="<?= $prow['id'] ?>">
                                        <div class=" input-group input-group-sm">
                                            <input type="text" name="cName" id="cName" class="form-control bg-dark text-light">
                                            <button name="add_candidate" class="btn btn-sm border btn-outline-primary" data-bs-toggle="modal" data-bs-target="#candidateModal">Add Candidate</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        <?php }
                        $pstmt->close();
                        ?>
                        <div class="col">
                            <form class=" d-flex flex-column justify-content-center align-items-center p-3 border rounded-3 h-100" action="<?php echo htmlentities($_SERVER['PHP_SELF']) ?>" method="post">
                                <div class="mb-3 col-10">
                                    <label for="pTitle" class="form-label">Position Title:</label>
                                    <input type="text" class="form-control bg-dark text-light" name="pTitle" id="pTitle">
                                </div>
                                <input type="hidden" name="election_id" value="<?= $row['id'] ?>">
                                <button name="add_position" class="btn btn-sm border btn-outline-primary">Add New Position</button>
                            </form>
                        </div>
                    </div>
                </section>
            <?php
            };
            if (!$hasRows) {
                echo '<h3 class="text-center mt-5">NO ELECTION YET</h3>';
            }
            ?>
        </main>

        <!-- create election modal -->
        <div class="modal fade" id="elctionModel" tabindex="-1" aria-labelledby="elctionModelLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content bg-dark text-white">
                    <div class="modal-header">
                        <h5 class="modal-title" id="elctionModelLabel">New election</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
                        <div class="modal-body row g-3">
                            <div class="mb-3 col-12">
                                <label for="title" class="form-label">Election Title:</label>
                                <input type="text" class="form-control bg-dark text-white" name="title" id="title" placeholder="e.g NACOS Election 2026">
                            </div>
                            <div class="mb-3 col-12">
                                <label for="description" class="form-label">Description:</label>
                                <textarea class=" form-control bg-dark text-white" name="description" id="description" rows="3" placeholder="Brief description of the election"></textarea>
                            </div>
                            <div class="mb-3 col-6">
                                <label for="startDate" class="form-label">Start Date:</label>
                                <input type="date" class="form-control bg-dark text-white" name="startDate" id="startDate">
                            </div>
                            <div class="mb-3 col-6">
                                <label for="endDate" class="form-label">End Date:</label>
                                <input type="date" class="form-control bg-dark text-white" name="endDate" id="endDate">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="create_election" class="btn btn-primary">Create Election</button>
                        </div>
                </div>
                </form>
            </div>
        </div>
    </body>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).on("change", ".toggle-election", function() {
            let electionId = $(this).data("id");
            let isActive = $(this).is(":checked");

            $.ajax({
                url: "../includes/toggle_election.php",
                type: "POST",
                data: {
                    id: electionId,
                    status: isActive
                },
                success: function(response) {
                    // console.log(isActive);
                }
            });
        });
    </script>


    </html>
<?php
    if (isset($_POST['create_election'])) {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];
        $sql = "INSERT INTO elections (title, description, start_date, end_date) VALUES (?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $title, $description, $startDate, $endDate);
        if ($stmt->execute()) {
            header('Location: elections.php');
            die();
        }
    }

    if (isset($_POST['add_position'])) {
        $title = $_POST['pTitle'];
        $election_id = $_POST['election_id'];
        $sql = "INSERT INTO positions (election_id, title) VALUES (?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $election_id, $title);
        if ($stmt->execute()) {
            header('Location: elections.php');
            die();
        }
    }

    if (isset($_POST['add_candidate'])) {
        $name = $_POST['cName'];
        $position_id = $_POST['position_id'];
        $sql = "INSERT INTO candidates (position_id, name) VALUES (?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $position_id, $name);
        if ($stmt->execute()) {
            header('Location: elections.php');
            die();
        }
    }

    mysqli_close($conn);
} else {
    header("Location: ../login.php");
}
?>