<?php
$con = new mysqli("localhost", "root", "", "webprotb");

if ($con->connect_error) {
    die($con->connect_error);
} else {
    // echo "Connected";
}
