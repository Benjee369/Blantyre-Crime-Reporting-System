<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title">
                    <?php
                        if (isset($_SESSION['admin_email'])) {
                            echo "<p>Welcome, " . $_SESSION['admin_email'] . "</p>";
                        }
                    ?>
                </li>
                <li class="active">
                    <a href="Admin_Side.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
                </li>
				<li>
                    <a href="Appointments.php"><i class="fa fa-user-md"></i> <span>Manage reports</span></a>
                </li>
                <li>
                    <a href="Manage_Users.php"><i class="fa fa-wheelchair"></i> <span>Manage Users</span></a>
                </li>
                <li>
                    <a href="Manage_Officers.php"><i class="fa fa-calendar"></i> <span>Officers</span></a>
                </li>
                <li>
                    <a href="appointments.html"><i class="fa fa-calendar"></i> <span>Statistics</span></a>
                </li>
            </ul>
        </div>
    </div>
</div>