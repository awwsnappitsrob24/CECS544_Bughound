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

        <h2><center><font color="gray">Add an Employee Entry</font></center></h2>

        <form name="add_employee_form" action="add_employee_post.php" method="post" onsubmit="return validate(this)">
            <table>
                <tr><td>First Name:</td><td><input type="Text" name="first_name" /></td></tr>
                <tr><td>Last Name:</td><td><input type="Text" name="last_name" /></td></tr>
                <tr><td>Username:</td><td><input type="Text" name="user_name" /></td></tr>
                <tr><td>Password:</td><td><input type="Text" name="user_pass" /></td></tr>
                <tr>
                    <td>Position:</td>
                    <td>
                    <select name="position" required>
                            <option value="">Select Position</option>
                            <option value="programmer">Programmer</option>
                            <option value="designer">Designer</option>
                            <option value="tester">Tester</option>
                            <option value="manager">Manager</option>
                    </select>
                    </td>
                </tr>     
                <tr><td>Group Number</td><td><input type="Text" name="group_num"></td></tr>
                <tr><td>Is a reporter?</td><td><input type="checkbox" name="is_reporter" value="True" /></td></tr>
                <tr><td>User Level:</td><td><input type="Number" name="user_level" /></td></tr>      
            </table>
            <input type="submit" name="submit" value="Submit" />
            <input class="button" type="button" onclick="window.location.replace('index.php')" value="Cancel" />
        </form>

        <script language=Javascript>
            function validate(theform) {
                if(theform.first_name.value.trim() === ""){
                    alert ("First Name field must contain characters");
                    return false;
                }
                if(theform.last_name.value.trim() === ""){
                    alert ("Last Name field must contain characters");
                    return false;
                }
                if(theform.user_name.value.trim() === ""){
                    alert ("User name field must contain characters");
                    return false;
                }
                if(theform.user_pass.value.trim() === ""){
                    alert ("Password field must contain characters");
                    return false;
                }
                if(theform.position.value === ""){
                    alert ("Must select a position");
                    return false;
                }
                if(theform.group_num.value.trim() === ""){
                    alert ("Group number field must contain a number");
                    return false;
                }
                if(theform.user_level.value === "" || theform.user_level.value <= 0 || theform.user_level.value > 5){
                    alert ("User Level field must contain a number from 1-5");
                    return false;
                }
                return true;
            }
        </script>
    </body>
</html>
