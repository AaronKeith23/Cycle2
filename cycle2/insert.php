<?php
/*
 * Created with PHP Storm
 * By: Aaron Keith
 * Cycle 2 CSCI 495
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$fullname = "";
$password = "";
$email = "";
$phone = 0;
$goat = "";
$match = false;

//Establish Connection
function dbconnection()
{
    //trying to connect to database
    try {
        $dbhost = "localhost";
        $dbuser = "csci22501fa18";
        $dbpass = "csci22501fa18!";
        $db = "csci22501fa18";
        $conn = new mysqli($dbhost, $dbuser, $dbpass, $db) or die("Connect failed: %s\n" . $conn->error);
        return $conn;
    } catch (PDOException $e) {
        die($e->getMessage());
    }
} // closing function dbconnection
if (isset ($_POST['fullname']) || isset ($_POST['password']) || isset ($_POST['email']) || isset ($_POST['phone']) || isset ($_POST['goat'])) {
        $fullname = $_POST['fullname'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $goat = $_POST['goat'];
		} // closing statement for entering the users information
		if (mysqli_connect_error()) {
            die ('Connect Error (' . mysqli_connect_errno() . ')' . mysqli_connect_error());
            echo "An error has occured with Database";
			}
        else {
            $SELECT = "SELECT email From register Where email = ?";
            $INSERT = "INSERT Into register values (?,?,?,?,?)";
            //Prepare Statement
            $conn = dbconnection();
            if ($conn == null) {
                echo "failed to connect to database" . mysqli_connect_error();
            } else {
                $stmt = $conn->prepare($SELECT);
                $stmt->bind_param('s',$email);
                $stmt->execute();
                $stmt->store_result();
                while ($e = $stmt->fetch()) {
                    $useremail = $e['email'];
                    if ($email == $e['email']) {
                        $match = true;
                    }
                }//closing while loop

            }
            if (!$match) {
                $conn = null;
                $conn = dbconnection();
                $stmt = $conn->query("INSERT Into register values (null,'$fullname','$password','$email','$phone','$goat')");
                if($stmt == true) {
                    echo "Your Choice has Been Successfully Recorded";
                }
                else {
                    echo "failed to insert data" . mysqli_error($conn);
                }
            } //closing !$match statement
            else {
                echo "This Email has already been registered Please Try New Email";
            }
        }// checking for db connection
?>
