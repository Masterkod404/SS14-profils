<?php
    session_start();
    $db_Server=new mysqli("localhost","root","","db_UsersServer");
    $db_ServerSS14 = new SQLite3('D:\Сервер SS14\SS14-Server\data\preferences.db');

?>