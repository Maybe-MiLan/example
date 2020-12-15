<?php

const HOST= "localhost";
const USER= "root";
const PASS= "";
const BASE= "work1";
const TABLE_USER= "users";
const TABLE_OFFICES="offices";
const TABLE_ROLE = "roles";
const TABLE_RESAN = "timelog";

$db = new mysqli(HOST,USER, PASS,BASE)
    or die ("cannot connect db");


session_start();

date_default_timezone_set("UTC");
$time = time();
$time += 5 * 3600;
$obg = Date("H:i:s", $time);

$dat = date("Y-m-d");

