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
        <!-- ADD YOUR DB INFO HERE -->
        <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $conn = new mysqli($servername, $username, $password);
            mysqli_select_db($conn, "bughound_db");

            $report_id = $_GET['report_id'];
            //echo $report_id;

            $program_id = $_POST['program_id'];
            $report_type = $_POST['report_type'];
            $severity = $_POST['severity'];
            $summary = $_POST['summary'];
            if(isset($_POST['reproducible']) && $_POST['reproducible'] === "checked") {
                $reproducible = 1;
            } else {
                $reproducible = 0;
            }
            $problem_description = $_POST['problem_description'];
            $suggested_fix = $_POST['suggested_fix'];
            $reported_by = $_POST['reported_by'];
            $date_discovered = $_POST['date_discovered'];
            $area_id = $_POST['area_id'];
            $assigned_to = $_POST['assigned_to'];
            $status = $_POST['status'];
            $priority = $_POST['priority'];
            $resolution = $_POST['resolution'];
            $resolution_version = $_POST['resolution_version'];
            $resolved_by = $_POST['resolved_by'];
            $date_resolved = $_POST['date_resolved'];
            $tested_by = $_POST['tested_by'];
            $date_tested = $_POST['date_tested'];
            if(isset($_POST['treat_deferred']) && $_POST['treat_deferred'] === "checked") {
                $treat_deferred = 1;
            } else {
                $treat_deferred = 0;
            }


			//$sql_attach = "SELECT file_name FROM attachments WHERE report_id = '".$report_id."'";
			//$attach_result = $conn->query($sql_attach);
			//$attach_row=$attach_result->fetch_assoc();
			//$file_name = $attach_row['file_name'];
			//echo $file_name;
			
			$has_attachments = 0;
			
			$attachment_query = "SELECT has_attachments FROM bugs WHERE report_id = '".$report_id."'";
			$attach_result = $conn->query($attachment_query);
			$attach_row=$attach_result->fetch_assoc();
			$has_attachments = $attach_row['has_attachments'];
			//echo $has_attachments;
			
			if($has_attachments === 1) {
				if(!file_exists($_FILES['attachments']['tmp_name']) || !is_uploaded_file($_FILES['attachments']['tmp_name'])) {
					$has_attachments = 1;
					$file_root = $_SERVER['DOCUMENT_ROOT']; // root path
					
					// parse current_page to remove query string
					$current_page = basename(__FILE__); // current page name
					$parsed_url = strtok($_SERVER["REQUEST_URI"],'?');
					
					$parent = basename(__DIR__); // parent folder name
					
					//$mid_path = str_replace('/'.$parent.'/'.$current_page, '', $_SERVER['REQUEST_URI']); // path after root path
					$mid_path = str_replace('/'.$parent.'/'.$current_page, '', $parsed_url); // path after root path
					
					
					$target_dir = $file_root . $mid_path . "/uploads/"; // target directory
					
					// Make directory if doesn't exist with permissions
					if(!is_dir($target_dir)) {
						mkdir($target_dir, 0755);
					}
					
					$target_file = $target_dir . basename($_FILES["attachments"]["name"]);
					
					$db_file_name = $mid_path . "/uploads/" . basename($_FILES["attachments"]["name"]);
					
					$uploadOk = 1;
					//$file_name = basename($_FILES["attachments"]["name"]);
					$fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION)); // file type
					
					// Check if file already exists
					if (file_exists($target_file)) {
						echo "Sorry, file already exists.";
						//echo "console.log('Sorry, file already exists.');";
						$uploadOk = 0;
					}

					// Check if $uploadOk is set to 0 by an error
					if ($uploadOk == 0) {
						echo "Sorry, your file was not uploaded.";
						echo "console.log('Sorry, file not uploaded.');";
					// if everything is ok, try to upload file
					} else {
						if (move_uploaded_file($_FILES["attachments"]["tmp_name"], $target_file)) {
							echo "The file ". basename( $_FILES["attachments"]["name"]). " has been uploaded.";
							//echo "console.log('File uploaded.');";
						} else {
							echo "Sorry, there was an error uploading your file.";
							//echo "console.log('Sorry, error.');";
						}
					}		
					
					$conn = new mysqli($servername, $username, $password);
					mysqli_select_db($conn, "bughound_db");
					
					$sql_report = "SELECT report_id FROM bugs ORDER BY report_id DESC LIMIT 1";
					$report_result = $conn->query($sql_report);
					$report_row=$report_result->fetch_assoc();
					$last_report_id = $report_row['report_id'];
					
					$stmt = $conn->prepare("UPDATE attachments SET file_name = ?, file_type = ? WHERE report_id = ?");
					$stmt->bind_param("ssi", $db_file_name, $fileType, $last_report_id);
					//$stmt->execute();
					echo $last_report_id;
					echo $stmt;
				}
				else {
					$has_attachments = 1;
				}
			}
			else {
				if(is_uploaded_file($_FILES['attachments']['tmp_name'])) {
					$has_attachments = 1;
					$file_root = $_SERVER['DOCUMENT_ROOT']; // root path
					
					// parse current_page to remove query string
					$current_page = basename(__FILE__); // current page name
					$parsed_url = strtok($_SERVER["REQUEST_URI"],'?');
					
					$parent = basename(__DIR__); // parent folder name
					
					//$mid_path = str_replace('/'.$parent.'/'.$current_page, '', $_SERVER['REQUEST_URI']); // path after root path
					$mid_path = str_replace('/'.$parent.'/'.$current_page, '', $parsed_url); // path after root path
					
					
					$target_dir = $file_root . $mid_path . "/uploads/"; // target directory
					
					// Make directory if doesn't exist with permissions
					if(!is_dir($target_dir)) {
						mkdir($target_dir, 0755);
					}
					
					$target_file = $target_dir . basename($_FILES["attachments"]["name"]);
					
					$db_file_name = $mid_path . "/uploads/" . basename($_FILES["attachments"]["name"]);
					
					$uploadOk = 1;
					//$file_name = basename($_FILES["attachments"]["name"]);
					$fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION)); // file type
					
					// Check if file already exists
					if (file_exists($target_file)) {
						echo "Sorry, file already exists.";
						//echo "console.log('Sorry, file already exists.');";
						$uploadOk = 0;
					}

					// Check if $uploadOk is set to 0 by an error
					if ($uploadOk == 0) {
						echo "Sorry, your file was not uploaded.";
						echo "console.log('Sorry, file not uploaded.');";
					// if everything is ok, try to upload file
					} else {
						if (move_uploaded_file($_FILES["attachments"]["tmp_name"], $target_file)) {
							echo "The file ". basename( $_FILES["attachments"]["name"]). " has been uploaded.";
							//echo "console.log('File uploaded.');";
						} else {
							echo "Sorry, there was an error uploading your file.";
							//echo "console.log('Sorry, error.');";
						}
					}		
					
					$conn = new mysqli($servername, $username, $password);
					mysqli_select_db($conn, "bughound_db");
					$stmt = $conn->prepare("INSERT INTO attachments (file_name, file_type) VALUES (?, ?)");
					$stmt->bind_param("ss", $db_file_name, $fileType);
					$stmt->execute();
			
			
					$get_reportid_sql = "SELECT report_id FROM bugs ORDER BY report_id DESC LIMIT 1";
					$get_reportid_result = $conn->query($get_reportid_sql);
					$get_reportid_row=$get_reportid_result->fetch_assoc();
					//echo "console.log('This is the report id: ".$get_reportid_row['report_id']."');";

					$get_fileid_attach = "SELECT file_id FROM attachments ORDER BY file_id DESC LIMIT 1";
					$get_fileid_result = $conn->query($get_fileid_attach);
					$get_fileid_row=$get_fileid_result->fetch_assoc();
					//echo "console.log('This is the att id: ".$get_fileid_row['file_id']."');";

					
					//$update_sql = "UPDATE attachments SET report_id = '".$get_reportid_row['report_id']."' WHERE file_id = '".$get_fileid_row['file_id']."'";
					$update_sql = "UPDATE attachments SET report_id = '".$report_id."' WHERE file_id = '".$get_fileid_row['file_id']."'";
					//echo "console.log('This is the sql: ".$update_sql."');";

					$conn->query($update_sql);

				}
				else {
					$has_attachments = 0;
				}
			}
			
			/**
			if(!file_exists($_FILES['attachments']['tmp_name']) || !is_uploaded_file($_FILES['attachments']['tmp_name'])) {){
				$has_attachments = 1;
                $file_root = $_SERVER['DOCUMENT_ROOT']; // root path
				
				// parse current_page to remove query string
                $current_page = basename(__FILE__); // current page name
				$parsed_url = strtok($_SERVER["REQUEST_URI"],'?');
				
                $parent = basename(__DIR__); // parent folder name
				
                //$mid_path = str_replace('/'.$parent.'/'.$current_page, '', $_SERVER['REQUEST_URI']); // path after root path
				$mid_path = str_replace('/'.$parent.'/'.$current_page, '', $parsed_url); // path after root path
				
				
                $target_dir = $file_root . $mid_path . "/uploads/"; // target directory
				
                // Make directory if doesn't exist with permissions
                if(!is_dir($target_dir)) {
                    mkdir($target_dir, 0755);
                }
				
				$target_file = $target_dir . basename($_FILES["attachments"]["name"]);
				
                $db_file_name = $mid_path . "/uploads/" . basename($_FILES["attachments"]["name"]);
				
				$uploadOk = 1;
				//$file_name = basename($_FILES["attachments"]["name"]);
				$fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION)); // file type
				
				// Check if file already exists
				if (file_exists($target_file)) {
					echo "Sorry, file already exists.";
                    //echo "console.log('Sorry, file already exists.');";
					$uploadOk = 0;
				}

				// Check if $uploadOk is set to 0 by an error
				if ($uploadOk == 0) {
					echo "Sorry, your file was not uploaded.";
                    echo "console.log('Sorry, file not uploaded.');";
				// if everything is ok, try to upload file
				} else {
					if (move_uploaded_file($_FILES["attachments"]["tmp_name"], $target_file)) {
						echo "The file ". basename( $_FILES["attachments"]["name"]). " has been uploaded.";
                        //echo "console.log('File uploaded.');";
					} else {
						echo "Sorry, there was an error uploading your file.";
                        //echo "console.log('Sorry, error.');";
					}
				}		
				
				$conn = new mysqli($servername, $username, $password);
				mysqli_select_db($conn, "bughound_db");
				
				$sql_report = "SELECT report_id FROM bugs ORDER BY report_id DESC LIMIT 1";
                $report_result = $conn->query($sql_report);
                $report_row=$report_result->fetch_assoc();
				$last_report_id = $report_row['report_id'];
				
				$stmt = $conn->prepare("UPDATE attachments SET file_name = ?, file_type = ? WHERE report_id = ?");
				$stmt->bind_param("ssi", $db_file_name, $fileType, $last_report_id);
				$stmt->execute();
			}*/
			
            $comments = $_POST['comments'];

            //  OPTIONAL

            if($area_id === "default") {
                $area_id = NULL;
            }
            if($assigned_to === "default") {
                $assigned_to = NULL;
            }
            if($status === "default") {
                $status = NULL;
				$is_visible = 1;
            }else if($status === "closed") {
				$is_visible = 0;
			}
			else {
				$is_visible = 1;
			}
			
            if($priority === "default") {
                $priority = NULL;
            }
            if($resolution === "default") {
                $resolution = NULL;
            }
            if($resolution_version === "default") {
                $resolution_version = NULL;
            }
            if($resolved_by === "default") {
                $resolved_by = NULL;
            }
            if($date_resolved === "") {
                $date_resolved = NULL;
            }
            if($tested_by === "default") {
                $tested_by = NULL;
            }
            if($date_tested === "") {
                $date_tested = NULL;
            }

            //echo $report_id;

            $stmt = $conn->prepare("UPDATE bugs SET program_id = ?, report_type = ?, severity = ?, summary = ?, reproducible = ?, problem_description = ?, suggested_fix = ?, reported_by = ?, date_discovered = ?, area_id = ?, assigned_to = ?, status = ?, priority = ?, resolution = ?, resolution_version = ?, resolved_by = ?, date_resolved = ?, tested_by = ?, date_tested = ?, treat_deferred = ?, has_attachments = ?, comments = ?, is_visible = ? WHERE report_id = ?");
            $stmt->bind_param("isissssisiisisiisissssii", $program_id, $report_type, $severity, $summary, $reproducible, $problem_description, $suggested_fix, $reported_by, $date_discovered, $area_id, $assigned_to, $status, $priority, $resolution, $resolution_version, $resolved_by, $date_resolved, $tested_by, $date_tested, $treat_deferred, $has_attachments, $comments, $is_visible, $report_id);
            $stmt->execute();

			
            $stmt->close();
            $conn->close();
			
            header("Location: index.php");
            exit;
            
        ?>
    </body>
</html>
