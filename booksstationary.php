<?php
require_once "config.php";


$sql = "SELECT advertiser_URL, advertiser_logo FROM advertisers WHERE advertiser_Category = 'Books & Stationary' ORDER BY advertiser_name ASC ";
if ($result = mysqli_query($link, $sql))
{
    if (mysqli_num_rows($result) > 0)
    {
        echo "<div class=row>";
        while ($row = mysqli_fetch_array($result))
        {   
            echo "<div class=col-md-4 style='padding: 15px;'><a href= " . $row['advertiser_URL'] . "><img src='data:image/jpeg;base64," . base64_encode($row['advertiser_logo']) . "'/></div>";
        }
        echo "</div>";
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
?>

