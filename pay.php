<?php
    $b=$_POST['bal'];
    $n=$_POST['mobile'];
    $to=$_POST['id'];
    $amt =$_POST['amt'];

    if ($b >= $amt) {
        $servername = "localhost";
        $username = "root";
        $password = "YES";
        $dbname = "ewallet";
        $b=$_POST['bal'];
        $bal=null;
        $name=null;
        echo $n;
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            $url="Location:index.php?id=connection_lost";
            header($url);
        }
        $sql1 = "select * from users";
        $result = $conn->query($sql1);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                if ($row['mobile'] == $n) {
                    $bal = $row['bal'];
                    $name = $row['name'];
                }
            }
        } else {
            echo "else";
            $url="Location:index.php?id=no_user";
            header($url);
        }
        echo "bal1".$bal;
        $b=$bal-$amt;
        $sql4 = "UPDATE users SET bal=$b WHERE mobile='$n'";
        $sql2 = "select * from users";
        $result = $conn->query($sql1);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                if ($row['mobile'] == $to) {
                    $bal = $row['bal'];
                }
            }
        } else {
            echo "else";
            $url="Location:index.php?id=no_user";
            header($url);
        }
        $b=$bal+$amt;
        echo "bal2".$bal;
        $sql3 = "UPDATE users SET bal=$b WHERE mobile='$to'";


        if ($conn->query($sql3) === TRUE && $conn->query($sql4) === TRUE) {
            echo "Record updated successfully";
            $url="Location:dashboard.php?id=successp&name=$name";
            header($url);
        } else {
            echo "Error updating record: " . $conn->error;
        }

        $conn->close();
    }
    else {
        $url="Location:dashboard.php?id=insufficient&name=$name";
        header($url);
    }
?>
