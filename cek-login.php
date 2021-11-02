<?php

session_start();

if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
    header("location : login.php");
}

include "db.conn.php";

if (isset($_POST["username"]) && isset($_POST["password"])) {
    function validate($data)
    {
        $data = trim($data); // " Hello World "
        $data = stripslashes($data); // mengonvert \ 'become'
        $data = htmlspecialchars($data); // <a>qwertyuiop</a>
        return $data;
    }
    $uname = validate($_POST["username"]);
    $pass = validate($_POST["password"]);


    // md5, sha256, md1
    $md5pass = hash("md5", $pass);

    if (empty($uname)) {
        header("location: login.php?error=Username wajib diisi bro!");
        exit();
    } else if (empty($pass)) {
        header("location: login.php?error=Password Harus Diisi bro!");
    } else {
        $sql = "SELECT * FROM users WHERE username='$uname' AND
        password='$md5pass'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);

            if ($row['username'] === $uname && $row['password'] === $md5pass) {
                $_SESSION['username'] = $row["username"];
                $_SESSION['name'] = $row["name"];
                $_SESSION['id'] = $row["id"];

                header("location: login.php");
                exit();
            } else {
                die("Login Gagal !");
            }
        } else {
            header("location: login.php?error=username dan password tidak ditemukan");
        }
    }
} else {
    header("location: login.php?error=Username dan Password Harus diisi !");
}
