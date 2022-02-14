<?php
include "allFunction.php";

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
                if ($total_page_need <= 8) {
                    selectLoop(1, $total_page_need, $page, $limit_per_page);
                } else {
                    if ($page < 6) {

                        selectLoop(1, 6, $page, $limit_per_page);

                        echo "<li class='page-item page-link'> ... </li>";
                        echo "<li class='page-item'><a class='page-link ' href='index.php?pageNo=$total_page_need&limit=$limit_per_page '> $total_page_need </a></li>";
                    } elseif ($page > 4 && $page < $total_page_need - 2) {
                        echo "<li class='page-item'><a class='page-link ' href='index.php?pageNo=1&limit=$limit_per_page'>1</a></li>";
                        echo "<li class='page-item'><a class='page-link ' href='index.php?pageNo=2&limit=$limit_per_page'>2</a></li>";
                        echo "<li class='page-item page-link'> ... </li>";

                        selectLoop($page - 2, $page + 1, $page, $limit_per_page);

                        echo "<li class='page-item page-link'> ... </li>";
                        echo "<li class='page-item'><a class='page-link ' href='index.php?pageNo=$total_page_need&limit=$limit_per_page'> $total_page_need </a></li>";
                    } else {

                        echo "<li class='page-item'><a class='page-link ' href='index.php?pageNo=1&limit=$limit_per_page'>1</a></li>";
                        echo "<li class='page-item'><a class='page-link ' href='index.php?pageNo=2&limit=$limit_per_page'>2</a></li>";
                        echo "<li class='page-item page-link'> ... </li>";

                        selectLoop($page - 1, $total_page_need, $page, $limit_per_page);
                    }
                }
                ?>

                <li class="page-item <?php echo $disable[1]; ?>">
                    <a class="page-link" href="index.php?pageNo=<?php echo $page + 1 . "&limit=$limit_per_page"; ?>">Next</a>
                </li>

            </ul>
        </nav>




    </div>

</body>

</html>