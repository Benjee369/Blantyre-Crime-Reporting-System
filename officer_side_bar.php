<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title">Main</li>
                <?php
                        if (isset($_SESSION['officer_id'])) {
                            echo "<p>Welcome, Officer ID: " . $_SESSION['officer_id'] . "</p>";
                        }
                    ?>
                <li class="active">
                    <a href="Officer_Side.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
                </li>
				<li>
                    <a href="Manage_Reports.php"><i class="fa fa-folder-open"></i> <span>Assigned Reports</span></a>
                </li>
                <li>
                    <a href="All_Maps.php"><i class="fa fa-map-marker"></i> <span>Incident Map</span></a>
                </li>
            </ul>
        </div>
    </div>
</div>