<aside class="side_nav position-sticky top-0 py-2 pt-4 px-4 text-center d-md-flex flex-column align-items-center border-end border-secondary-subtle" style="height: 100vh; width: fit-content;">
        <a href="/admin/dashboard.php" class="logo fs-4 fw-bold text-decoration-none d-flex align-items-center mt-4">
            <img src="../asset/images/logo.png" class="icon" alt="" style="width: 40px" />
            E-Voting
        </a>
        <ul class="nav flex-column gap-4 mt-5 pt-0 h-100">
            <li class="nav-item">
                <a class="nav-link active fs-5 fw-semibold d-flex align-items-center gap-2" aria-current="page" href="dashboard.php">
                    <img src="../asset/images/dashboardd.png" alt="dashboard" style="width: 30px;" />
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link fs-5 fw-semibold d-flex align-items-center gap-2" aria-current="page" href="elections.php">
                    <img src="../asset/images/calendarr.png" alt="position" style="width: 30px;" />
                    Elections
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link fs-5 fw-semibold d-flex align-items-center gap-2" aria-current="page" href="results.php">
                    <img src="../asset/images/report.png" alt="results" style="width: 30px;" />
                    Results
                </a>
            </li>

            <li class="nav-item mt-auto">
                <a href="#" class="nav-link fs-5 fw-semibold d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    <img src="../asset/images/signoutt.png" alt="signout" style="width: 30px;" />
                    Sign out
                </a>
            </li>

        </ul>
    </aside>
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
                    <a href="../includes/logout.php" class="btn btn-secondary">Sign Out</a>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal"> Cancel!</button>
                </div>
            </div>
        </div>
    </div>
