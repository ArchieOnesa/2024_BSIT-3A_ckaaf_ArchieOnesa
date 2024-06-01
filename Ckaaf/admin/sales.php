<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ckaaf - Admin Dashboard</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
    <link rel="stylesheet" href="style.css">
    
</head>

<body>
    <section id="header">
        <a href="#"><img src="../img/logo.png" class="logo" alt="Ckaaf Logo"></a>
        <div>
            <ul id="navbar">
                <li><a href="my_shop.php">View Shop</a></li>
                <li><a class="active" href="index.php">Dashboard</a></li>
                <li><a href="inventory.php">Inventory</a></li>
                <li><a href="orders.php">Orders</a></li>
                <div class="dropdown">
                    <button class="dropbtn"><img src="../img/people/uicon.jpeg" class="uicon" alt="User Icon"></button>
                    <div class="dropdown-content">
                        <a href="../request/logout.php">Logout</a>
                    </div>
                </div>
                <a href="#" id="close"><i class="far fa-times"></i></a>
            </ul>
        </div>
        <div id="mobile">
            <img src="../img/people/uicon.jpeg" class="uicon" alt="User Icon">
            <i id="bar" class="fas fa-outdent"></i>
        </div>
    </section>

    <div class="dashboard">
    <a href="index.php" class="back-button">Back</a>
        <div class="box_container">
    
            <div class="box">
                <?php
                include "../connection.php";

                $query = "
                    SELECT p.prodname, SUM(o.quantity) AS total_sold
                    FROM orders o
                    JOIN products p ON o.prodId = p.prodId
                    GROUP BY o.prodId
                    ORDER BY total_sold DESC
                    LIMIT 10";
                $result = mysqli_query($conn, $query) or die('Query failed');
               
                ?>
                <h3>Top 10 Products Sold</h3>
                <ol>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                        echo '<li>' . $row['prodname'] . ' - ' . $row['total_sold'] . ' sold</li>';
                            
                        }
                    } else {
                        echo '<li>No products found.</li>';
                    }
                    ?>
                </ol>
            </div>
        </div>
        
        <div class="box1">
        <?php
            include "../connection.php";

            $today = date("Y-m-d");
            $yesterday = date("Y-m-d", strtotime("-1 day"));

            $query_today = "SELECT SUM(totalPrice) AS total_sales_today FROM sales WHERE DATE(orderDate) = '$today'";
            $result_today = mysqli_query($conn, $query_today);
            $row_today = mysqli_fetch_assoc($result_today);
            $total_sales_today = $row_today['total_sales_today'];

            $query_yesterday = "SELECT SUM(totalPrice) AS total_sales_yesterday FROM sales WHERE DATE(orderDate) = '$yesterday'";
            $result_yesterday = mysqli_query($conn, $query_yesterday);
            $row_yesterday = mysqli_fetch_assoc($result_yesterday);
            $total_sales_yesterday = $row_yesterday['total_sales_yesterday'];

            echo "<h3>Sales Today vs Yesterday</h3>";
            echo "<p>Today's Sales: $total_sales_today</p>";
            echo "<p>Yesterday's Sales: $total_sales_yesterday</p>";

            mysqli_close($conn);
        ?>
        </div>
        
        <div class="box1 bot">
        <?php
            include "../connection.php";

            $current_year = date("Y");
            $previous_year = $current_year - 1;

            $query_current_year = "SELECT SUM(totalPrice) AS total_sales_current_year FROM sales WHERE YEAR(orderDate) = '$current_year'";
            $result_current_year = mysqli_query($conn, $query_current_year);
            $row_current_year = mysqli_fetch_assoc($result_current_year);
            $total_sales_current_year = $row_current_year['total_sales_current_year'];

            $query_previous_year = "SELECT SUM(totalPrice) AS total_sales_previous_year FROM sales WHERE YEAR(orderDate) = '$previous_year'";
            $result_previous_year = mysqli_query($conn, $query_previous_year);
            $row_previous_year = mysqli_fetch_assoc($result_previous_year);
            $total_sales_previous_year = $row_previous_year['total_sales_previous_year'];

            echo "<h3>Sales This Year vs Last Year</h3>";
            echo "<p>This Year's Sales: $total_sales_current_year</p>";
            echo "<p>Last Year's Sales: $total_sales_previous_year</p>";

            mysqli_close($conn);
        ?>
        </div>

    </div>
</body>

</html>

<style>
    .dashboard {
        background: var(--orange);
        padding: 1rem;
        position: relative;
    }

    .box_container {
        display: flex;
        align-items: flex-start; 
        padding: 20px; 
        display: grid;
        grid-template-columns: repeat(2, 3fr);
        gap: 2rem;
        padding: 2% 5%;
    }

    .box, .box1{
        background-color: #f2f2f2; 
        border: 1px solid #ddd; 
        border-radius: 5px; 
        padding: 20px; 
        margin-right: 4rem; 
        box-shadow: var(--box-shadow);
        border: 1px solid #000;

    }

    .box1 { 
        margin-left: 55rem; 
        margin-top: -13.75rem;
    }

    .bot{
        margin-top: 1rem;
    }

     ol, .h3{
        padding: 40px;
    }

    .back-button {
        display: inline-block;
        padding: 10px 20px; 
        background-color: #007bff; 
        color: #fff;
        text-decoration: none; 
        border-radius: 5px; 
        margin-top: 20px;
        margin-left: 20px;
    }

    .back-button:hover {
        background-color: #0056b3; 
    }
</style>
