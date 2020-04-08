    <?php
$con = mysqli_connect('localhost', 'root', '');

if (!$con) {
    echo 'Server not connected!';
}

if (!mysqli_select_db($con, 'ksk')) {
    echo 'Database not selected.';
}

    // define variables and set to empty values
    $nameErr = $emailErr = $subjectErr = $messageErr = "";
    $Name = $Email = $Subject = $Message = "";

    if(isset($_POST['submit'])) {
        if (empty($_POST["Name"])) {
            $nameErr = "Name is required";
        } else {
            $Name = input($_POST["Name"]);
            // check if name only contains letters and whitespace
            if (!preg_match("/^[a-zA-Z ]*$/", $Name)) {
                $nameErr = "Only letters and white space allowed";
            }
        }

        if (empty($_POST["Email"])) {
            $emailErr = "Email is required";
        } else {
            $Email = input($_POST["Email"]);
            // check if e-mail address is well-formed
            if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format";
            }
        }

        if (empty($_POST["Subject"])) {
            $Subject = "";
        } else {
            $Subject = input($_POST["Subject"]);
        }
    }

    if (empty($_POST["Message"])) {
        $Message = "";
    } else {
        $Message = input($_POST["Message"]);
    }

    function input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

$sql = "Insert into contact (Name, Email, Subject, Message) VALUES(
    '$Name', '$Email', '$Subject', '$Message')";

if (!mysqli_query($con, $sql)) {
    echo 'Not inserted';
    header('refresh: 2; url = contact.php');
} else {
    echo ('Inserted');
}
header("refresh: 2; url = index.php");

?>