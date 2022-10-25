<?php
if (isset($_POST['submit'])) 
{
    if (isset($_POST['Email']) && isset($_POST['Password']) 
       ) {
        
        $Email = $_POST['Email'];
        $Password = $_POST['Password'];
       

        $host = "localhost:8080";
        $dbEmail = "sobiasafdar51@gmail.com";
        $dbPassword = "7624";
        $dbName = "test";

        $conn = new mysqli($host, "sobiasafdar51@gmail.com", "7624", $dbName);

        if ($conn->connect_error) {
            die('Could not connect to the database.');
        }
        else {
            $Select = "SELECT Email FROM register WHERE Email = ? LIMIT 1";
            $Insert = "INSERT INTO register (Email, Password) values(?, ?)";

            $stmt = $conn->prepare($Select);
            $stmt->bind_param("s", $Email);
            $stmt->execute();
            $stmt->bind_result($resultEmail);
            $stmt->store_result();
            $stmt->fetch();
            $rnum = $stmt->num_rows;

            if ($rnum == 0) {
                $stmt->close();

                $stmt = $conn->prepare($Insert);
                $stmt->bind_param("ssssii",$Email, $Password);
                if ($stmt->execute()) {
                    echo "New record inserted sucessfully.";
                }
                else {
                    echo $stmt->error;
                }
            }
            else {
                echo "Someone already registers using this email.";
            }
            $stmt->close();
            $conn->close();
        }
    }
    else {
        echo "All field are required.";
        die();
    }
}
else {
    echo "Submit button is not set";
}
?>