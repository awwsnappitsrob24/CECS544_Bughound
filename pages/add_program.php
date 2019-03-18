<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Bughound</title>
        <link rel="stylesheet" href="../assets/styles/nav_menu_style.css">
        <link rel="stylesheet" href="../assets/styles/vertical_menu_style.css">
        <link rel="stylesheet" href="../assets/styles/form_style.css">
    </head>
    <body>
        <?php
            session_start();
            if(isset($_SESSION['user_name']) && isset($_SESSION['user_level'])) {
                $user_level = $_SESSION['user_level'];
                $user_name = $_SESSION['user_name'];
            }
        ?>
        <ul>
            <li><a href="index.php">Home</a></li>
            <?php
                if(isset($_SESSION['user_name']) && isset($_SESSION['user_level'])) {
                    echo '<li class="dropdown">
                        <a href="javascript:void(0)" class="dropbtn">Bug Report</a>
                        <div class="dropdown-content">
                            <a href="create_report.php">Create</a>
                            <a href="search_reports.php?source=update">Update</a>
                            <a href="search_reports.php?source=search">Search</a>
                        </div>
                    </li>';
                    if($user_level == 5) {
                        echo '<li class="dropdown">
                        <a href="javascript:void(0)" class="dropbtn, active">Manage Database</a>
                        <div class="dropdown-content">
                            <a href="manage_programs.php">Programs</a>
                            <a href="manage_functional_areas.php">Functional Areas</a>
                            <a href="manage_employees.php">Employees</a>
                            <a href="manage_export.php">Exports</a>
                        </div>
                        </li>';
                        echo '<li style="float:right"><a href="logout.php">Logout</a></li>';
                        echo '<li style="float:right"><a>Welcome, '.$user_name.'</a></li>';
                    }
                } else {
                    echo '<li style="float:right"><a href="login.php">Login</a></li>';
                }
            ?>
        </ul>

        <h2><center><font color="gray">Add a Program Entry</font></center></h2>

        <form name="add_program_form" action="add_program_post.php" method="post" onsubmit="return validate(this)">
            <table>
                <tr><td>Program Name:</td><td><input type="Text" name="program_name" /></td></tr>
                <tr><td>Program Release:</td><td><input type="Number" name="program_release" /></td></tr>
                <tr><td>Program Version:</td><td><input type="Number" name="program_version" /></td></tr>
                <tr><td>Program Release Date:</td><td><input type="Date" name="program_release_date" /></td></tr>     
            </table>
            <input type="submit" name="submit" value="Submit" />
            <input class="button" type="button" onclick="window.location.replace('index.php')" value="Cancel" />
        </form>

        <script language=Javascript>
            function validate(theform) {
                if(theform.program_name.value.trim() === ""){
                    alert ("Program name field must contain characters");
                    return false;
                }
                if(theform.program_release.value.trim() === ""){
                    alert ("Program release field must contain characters");
                    return false;
                }
                if(theform.program_version.value.trim() === ""){
                    alert ("Program version field must contain characters");
                    return false;
                }
                if(theform.program_release_date.value === ""){
                    alert ("Program release date field must contain characters");
                    return false;
                }
                return true;
            }
        </script>
    </body>
</html>