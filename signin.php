<?php
    $name  = $_POST['username'];
    $pwd = md5($_POST['password']);
    $servername = "localhost";
    $username = "root";
    $password = "YES";
    $dbname = "ewallet";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "select name, password from users";
    $result = $conn->query($sql);

    try {
        if (!empty($result) && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                if($row['name']==$name && $row['password']==$pwd) {
                    $url = "Location:dashboard.php?name=$name";
                    echo "if";
                    header($url);
                    $found = true;
                }
            }
            if (!($found)) throw new Exception("");
        } else {
            echo "else";
            $url="Location:index.php?id=uname_pw";
            header($url);
        }
    } catch (Exception $e){
        $url="Location:index.php?id=no_user";
        header($url);
        $conn->close();
    }
?>
