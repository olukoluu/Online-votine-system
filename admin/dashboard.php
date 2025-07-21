<?php
ob_start();
include_once('../includes/connect.php');
session_start();



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
        <title>Admin Dashboard</title>
    </head>

    <body class=" position-relative d-flex" style="background-color: #00000f; color: #f5f5f5;">
        <?php
        include_once "sidenav.php";
        ?>
        <main class="p-md-4 pt-0 w-100">
            <div class="p-3 pt-md-0 d-flex justify-content-between align-items-center pb-2 border-bottom">
                <h4 class=" display-5 fs-2 fw-bold">Admin Dashboard</h4>
            </div>
            <section class="container mt-4">
                <div class="row g-5">
                    <div class="col-4">
                        <div class="p-3 bg-dark border rounded-2">
                            <div class=" mb-4 d-flex gap-4">
                                <span class=" bg-primary bg-gradient rounded-2 h-100 p-3"><img src="../asset/images/calendarr.png" alt="elections" style="width: 30px;"></span>
                                <div>
                                    <p class=" mb-0 fw-semibold text-secondary">Active Elections</p>
                                    <?php
                                    $sql = "SELECT COUNT(*) AS active_elections FROM elections WHERE status = 1";
                                    $stmt = mysqli_query($conn, $sql);
                                    $result = $stmt->fetch_column();
                                    echo '<p class="mb-0 fw-bold fs-3">'.$result.'</p>';
                                    ?>
                                    
                                </div>
                            </div>
                            <a href="elections.php" class=" text-decoration-none fw-semibold">View all elections</a>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-3 bg-dark border rounded-2">
                            <div class=" mb-4 d-flex gap-4">
                                <span class=" bg-success bg-gradient rounded-2 h-100 p-3"><img src="../asset/images/tick.png" alt="votes" style="width: 30px;"></span>
                                <div>
                                    <p class=" mb-0 fw-semibold text-secondary">Total Votes</p>
                                    <p class="mb-0 fw-bold fs-3">303</p>
                                </div>
                            </div>
                            <a href="results.php" class=" text-decoration-none fw-semibold">View voting stats</a>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-3 bg-dark border rounded-2">
                            <div class=" mb-4 d-flex gap-4">
                                <span class=" bg-danger bg-gradient rounded-2 h-100 p-3"><img src="../asset/images/people.png" alt="candidate" style="width: 30px;"></span>
                                <div>
                                    <p class=" mb-0 fw-semibold text-secondary">Registered Candidates</p>
                                    <p class="mb-0 fw-bold fs-3">13</p>
                                </div>
                            </div>
                            <a href="candidates.php" class=" text-decoration-none fw-semibold">View all Candidates</a>
                        </div>
                    </div>

                </div>
            </section>
            <section class=" container mt-4 ms-2 p-3 bg-dark border rounded-2">
                <h4>Upcoming Elections</h4>
                <table class="table table-dark table-hover mt-3">
                    <tbody><?php
                            $sql = "SELECT * FROM elections ORDER BY start_date";
                            $stmt = mysqli_query($conn, $sql);

                            while ($row = mysqli_fetch_array($stmt)) {
                                // $status = $row['status'] ? 'Active' : 'Inactive';
                                echo '
                            <tr>
                            <td>
                                <div class="">
                                    <h5>' . $row['title'] . '</h5>
                                    <p>' . $row['description'] . '</p>
                                </div>
                            </td>
                            <td>' . $row['start_date'] . '</td>
                            <td><span class="badge rounded-pill bg-primary text-capitalize small">'.$row['status'].'</span></td>
                        </tr>
                            ';
                            }
                            ?>
                    </tbody>
                </table>
            </section>
        </main>
    </body>

    </html>
<?php
    mysqli_close($conn);
} else {
    header("Location: ../login.php");
}
?>