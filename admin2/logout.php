<?php
/*
 * Created on May 30, 2008
 *
 * Author: Qingfeng Huang
 * Email: qingfeng@qhuang.com
 * 
 */
 session_start();
 unset($_SESSION['login']);
 header("Location: index.php");
?>
