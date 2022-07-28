
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Dashboard Template · Bootstrap v5.2</title>
        <link rel="canonical" href="https://getbootstrap.com/docs/5.2/examples/dashboard/">
        <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        <style type="text/css">
            .contentfromsidenav{
            margin-left: 15%;
            }
            @media only screen and (max-width:600px) {
            .contentfromsidenav {
            width:100%;
            }
            }
        </style>
        <!-- Custom styles for this template -->
        <link href="dashboard.css" rel="stylesheet">
    </head>

<body>
<div class="container">
<?php

require_once "config.php";

// Create connection
if ($link === false)
{
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$sql = "SELECT * FROM advertisers";
if ($result = mysqli_query($link, $sql))
{
    if (mysqli_num_rows($result) > 0)
    {

        while ($row = mysqli_fetch_array($result))
        {
            echo "<div class=row>";

            echo "<div class=col-md-2>" . $row['advertiser_id'] . "</div>";
          
            echo "<div class=col-md-2><a href= " . $row['advertiser_URL'] . "><img src='data:image/jpeg;base64," . base64_encode($row['advertiser_logo']) . "'/></div>";
            echo "</div>";

        }
    
        // Free result set
        mysqli_free_result($result);
    }
    else
    {
        echo "No records matching your query were found.";
    }
}
else
{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
mysqli_close($link);
?>
</div>
</body>
</html>