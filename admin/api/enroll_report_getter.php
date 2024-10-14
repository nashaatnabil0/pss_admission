<?php
include('../includes/dbconnection.php');
// Base SQL query
// $sql = "SELECT * FROM your_table_name";
$sql = "SELECT
                    en.ID,
                    en.traineeNID,
                    en.groupId,
                    en.paymentPlan,
                    COALESCE(en.paymentState, 'No Payment') as paymentState,
                    en.state,
                    en.discount,
                    en.date,
                    t.Name as Tname,
                    g.Title as Gtilte,
                    g.days as Gdays,
                    g.minAge as gminAge,
                    g.maxAge as gmaxAge,
                    g.Timeslot as Timing,
                    sp.name as spname
                  FROM 
                    enrollment en 
                  JOIN
                    trainees t on en.traineeNID=t.NID 
                  JOIN 
                    groups g on en.groupId=g.ID
                  JOIN
                    sport sp on g.sportId = sp.ID;";
// $sql = "SELECT
//                     g.Title as Gtilte,
//                     g.days as Gdays,
//                     g.minAge as gminAge,
//                     g.maxAge as gmaxAge,
//                     g.Timeslot as Timing,
//                     sp.name as spname
//                   FROM 
//                     groups g
//                   JOIN
//                     sport sp on g.sportId = sp.ID;";

// // Search filter
// if (!empty($search)) {
//     $sql .= " WHERE name LIKE '%$search%' OR position LIKE '%$search%'";  // Customize for your columns
// }

// Count total records
$resultTotal = $pdoConnection->query($sql);
$total = $resultTotal->rowCount();


// Fetch rows and prepare response
$rows = array();
while ($row = $resultTotal->fetch(PDO:: FETCH_ASSOC)) {
    $rows[] = $row;
}

// Return data in the format required by Bootstrap Table
// $response = array(
//     "total" => $total,
//     "rows" => $rows
// );

// Output the response in JSON format
header('Content-Type: application/json');
echo json_encode($rows);

// // Close connection
// $pdoConnection->close();

?>
