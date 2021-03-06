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
        <ul>
            <li><a href="index.php">Home</a></li>
            <li class="dropdown">
                <a href="javascript:void(0)" class="dropbtn, active">Bug Report</a>
                <div class="dropdown-content">
                    <a href="create_report.php">Create</a>
                    <?php
                        // See if user that logged in is of manager level (user level of 5)
                        session_start();
                        $user_level = $_SESSION['user_level'];
                        
                        if($user_level == 5) {
                            echo '<a href="search_reports.php?source=update">Update</a>';
                        }
                    ?>
                    <a href="search_reports.php?source=search">Search</a>
                </div>
            </li>
            <?php
                // See if user that logged in is of manager level (user level of 5)
                $user_level = $_SESSION['user_level'];
                
                if($user_level == 5) {
                    echo '<li class="dropdown">
                    <a href="javascript:void(0)" class="dropbtn">Manage Database</a>
                    <div class="dropdown-content">
                        <a href="manage_programs.php">Programs</a>
                        <a href="manage_functional_areas.php">Functional Areas</a>
                        <a href="manage_employees.php">Employees</a>
                        <a href="manage_export.php">Exports</a>
                    </div>
                    </li>';
                }
            ?>
        </ul>

        <h2><center><font color="gray">Register Bughound User</font></center></h2>

        <form name="add_employee_form" action="register_post.php" method="post" onsubmit="return validate(this)">
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
                <!-- No user level for registration, set default to 1.  -->    
            </table>
            <input type="submit" name="submit" value="Submit" />
            <input class="button" type="button" onclick="window.location.replace('register.php')" value="Cancel" />
        </form>

        <script language=Javascript>
            function validate(theform) {
                if(theform.first_name.value === ""){
                    alert ("Name field must contain characters");
                    return false;
                }
                if(theform.last_name.value === ""){
                    alert ("Name field must contain characters");
                    return false;
                }
                if(theform.user_name.value === ""){
                    alert ("User name field must contain characters");
                    return false;
                }
                if(theform.user_pass.value === ""){
                    alert ("Password field must contain characters");
                    return false;
                }
                if(theform.position.value === ""){
                    alert ("Must select a position");
                    return false;
                }
                if(theform.group_num.value === ""){
                    alert ("Group number field must contain a number");
                    return false;
                }
                return true;
            }
        </script>
    </body>
</html>
