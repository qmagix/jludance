<?php
/*
 * Created on Jul 21, 2008
 *
 * if sid (student.id) does not in participation table, set "done" else "active"
 *
 * Author: Qingfeng Huang
 * Email: qingfeng@qhuang.com
 * 
 */
 include("header.php");
 $db=new Database(DB_SERVER,DB_NAME,DB_USER,DB_PASS);
 runStudentStatusUpdate($db);
?>
