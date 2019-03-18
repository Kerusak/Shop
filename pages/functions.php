<?php

//Get Variables
$page = 1;
if (isset($_GET['page'])) {
    $page = $_GET['page'];
}

function Logging($text, $is_error = true)
{
    echo "<h2 style= color:$is_error ? 'red' : 'green'>$text</h2>";
    return $is_error ? false : '';
}

function log_db($err)
{
    if ($err && $err != 1062) {
        echo "<h2>Error code: $err</h2><br>";
        return false;
    } elseif ($err == 1062){
        Logging("User already exists");
        return false;
    }
    else{
        //Logging("Ok", false);
        return true;
    }
}

function connect($host = 'localhost', $user = 'root', $password = '', $dbname = 'travel')
{
    $link = mysql_connect($host, $user, $password) or die('Connection error');
    mysql_select_db($dbname) or die('Db open error');
}

function register($login, $password, $email)
{
    $login = trim(htmlspecialchars($login));
    $password = trim(htmlspecialchars($password));
    $email = trim(htmlspecialchars($email));
    if ($login == '' || $password == '' || $email == '') {
        Logging("Fill All Required Fields");
    }
    $password = md5($password);
    $ins = "insert into users (login, password, email, role_id) values('$login', '$password', '$email', 2)";
    connect();
    mysql_query($ins);
    return log_db(mysql_errno());
}

function reload(){
    echo "<script>";
    echo "window.location = document.URL;";
    echo "</script>";
}