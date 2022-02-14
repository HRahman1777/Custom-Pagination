<?php

include "db_conn.php";

$select_options_value = [10, 30, 50, 80, 100];


$limit_per_page = getLimit();

$total_number_of_data = totalData($connection);
$total_page_need = ceil($total_number_of_data / $limit_per_page);

$page = getPageNum($total_page_need);

$start_limit = ($page - 1) * $limit_per_page;
$final_data = dataPerPage($connection, $start_limit, $limit_per_page);


function totalData($conn)
{
    $sql_query = "SELECT * FROM users";
    $result = mysqli_query($conn, $sql_query);
    return mysqli_num_rows($result);
}

function getPageNum($tpn)
{
    if (isset($_GET['pageNo'])) {
        $p = $_GET['pageNo'];

        if ($p < 1) {
            $p = 1;
        } elseif ($p > $tpn) {
            $p = $tpn;
        }
    } else {
        $p = 1;
    }

    return $p;
}

function getLimit()
{
    if (isset($_POST['set_limit'])) {
        $page_limit = $_POST['set_limit'];
    } else {

        if (isset($_GET['limit'])) {
            $page_limit = $_GET['limit'];
        } else {
            $page_limit = 30;
        }
    }

    return $page_limit;
}

function setDistabled($p, $tpn)
{
    if ($p > 1) {
        $active_pre = '';
    } else {
        $active_pre = 'disabled';
    }

    if ($p < $tpn) {
        $active_next = '';
    } else {
        $active_next = 'disabled';
    }

    $disable = array($active_pre, $active_next);

    return $disable;
}

function dataPerPage($conn, $sl, $lpp)
{
    $sql_query = "SELECT * FROM users LIMIT $sl, $lpp";
    return mysqli_query($conn, $sql_query);
}

function dataDetailsPerPage($td, $st, $lpp)
{
    $from = $st + 1;
    $to = $st + $lpp;

    if ($to > $td) {
        $to = $td;
    }
    return array($from, $to);
}

function selectLoop($start, $end, $page, $lpp)
{

    for ($loop_page = $start; $loop_page <= $end; $loop_page++) {

        if ($loop_page == $page) {
            $active_page_number = 'active';
        } else {
            $active_page_number = '';
        }

        echo "<li class='page-item $active_page_number'><a class='page-link ' href='index.php?pageNo=$loop_page&limit=$lpp'> $loop_page </a></li>";
    }
}
