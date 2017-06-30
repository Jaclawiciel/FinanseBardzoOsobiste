<?php
session_start();
/**
 * Created by PhpStorm.
 * User: Jacek
 * Date: 30.06.2017
 * Time: 13:49
 */

$_SESSION['userID'] = "";
$_SESSION['password'] = "";
header("Location: ../html/sign-in.php");