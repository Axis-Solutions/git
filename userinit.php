<?php
session_start(); // Use session variable on this page. This function must put on the top of page.


include("lib/db.class.php");
if (!include_once "config.php") {
    header("location: install.php");
}

// Open the base (construct the object):
$db_sec = new DB($config['database'], $config['host'], $config['username'], $config['password']);

