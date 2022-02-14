<?php
include "db_conn.php";

$sql_query = "SELECT * FROM users";
$result = mysqli_query($connection, $sql_query);

$limit_per_page = getLimit();
$select_options_value = [10, 30, 50, 80, 100];

$total_number_of_data = mysqli_num_rows($result);
$total_page_need = ceil($total_number_of_data / $limit_per_page);
$page = getPageNum($total_page_need);

$start_limit = ($page - 1) * $limit_per_page;
$final_data = dataPerPage($connection, $start_limit, $limit_per_page);




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


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Custom Pagination - OrangeToolz</title>

    <!-- custom CSS -->
    <link rel="stylesheet" href="style.css">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <script src="script.js"></script>

</head>

<body>

    <div class="container">

        <h3 class="text-center">A Custom Pagination - User Details</h3>
        <hr>

        <form action="index.php" method="POST" class="form-limit">

            <select class="form-select" name="set_limit" onchange="this.form.submit()">
                <?php
                for ($i = 0; $i < count($select_options_value); $i++) {
                    $limit_per_page == $select_options_value[$i] ? $select_check = "Selected" : $select_check = "";

                    echo "<option $select_check value='$select_options_value[$i]'> $select_options_value[$i] </option>";
                }
                ?>
            </select>

        </form>

        <p>
            <?php
            $fromTo = dataDetailsPerPage($total_number_of_data, $start_limit, $limit_per_page);
            echo "Showing $fromTo[0] to $fromTo[1] Data from $total_number_of_data Data.";
            ?>
        </p>

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">#ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                </tr>
            </thead>
            <tbody>

                <?php while ($row = mysqli_fetch_array($final_data)) {
                    echo "<tr>";
                    echo "<th scope='row'>" . $row['id'] . "</th>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "</tr>";
                } ?>

            </tbody>
        </table>


        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">

                <?php
                $disable = setDistabled($page, $total_page_need);
                ?>
                <li class="page-item <?php echo $disable[0]; ?>">
                    <a class="page-link" href="index.php?pageNo=<?php echo $page - 1 . "&limit=$limit_per_page"; ?>" tabindex="-1" aria-disabled="true">Previous</a>
                </li>

                <?php
                for ($loop_page = 1; $loop_page <= $total_page_need; $loop_page++) {

                    if ($loop_page == $page) {
                        $active_page_number = 'active';
                    } else {
                        $active_page_number = '';
                    }
                ?>
                    <li class="page-item <?php echo $active_page_number; ?>"><a class="page-link " href="index.php?pageNo=<?php echo $loop_page . "&limit=$limit_per_page"; ?>"> <?php echo $loop_page; ?> </a></li>

                <?php }; ?>

                <li class="page-item <?php echo $disable[1]; ?>">
                    <a class="page-link" href="index.php?pageNo=<?php echo $page + 1 . "&limit=$limit_per_page"; ?>">Next</a>
                </li>

            </ul>
        </nav>




    </div>

</body>

</html>