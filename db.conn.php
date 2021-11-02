<?php

$conn = mysqli_connect("localhost", "root", "", "praktikum");

if (!$conn) {
    echo "Koneksi Gagal !";
} else {
    echo "Koneksi Berhasil !";
}
