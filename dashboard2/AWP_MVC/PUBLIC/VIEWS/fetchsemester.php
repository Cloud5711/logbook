<?php
 include('../../CONFIG/DB_Configuration.php');

// Query for the first semester
$queryFirstSemester = "SELECT 
    CONCAT(YEAR(date_visited), '/', IF(MONTH(date_visited) BETWEEN 8 AND 12, '1', '2')) as semester,
    COUNT(person_ID) as count
FROM 
    visitor_log
WHERE 
    YEAR(date_visited) = YEAR(CURDATE()) -- Only include data from the current year
    AND date_visited <= CURDATE() -- Only include data until the current date
GROUP BY 
    semester
ORDER BY 
    date_visited ASC";

$resultFirstSemester = mysqli_query($conn, $queryFirstSemester);

// Fetch data for the first semester
$firstSemesterData = array();
while ($row = mysqli_fetch_assoc($resultFirstSemester)) {
    $firstSemesterData[$row['semester']] = $row['count'];
}

// Query for the second semester
$querySecondSemester = "SELECT 
    CONCAT(YEAR(date_visited), '/', IF(MONTH(date_visited) BETWEEN 1 AND 6, '2', '1')) as semester,
    COUNT(person_ID) as count
FROM 
    visitor_log
WHERE 
    YEAR(date_visited) = YEAR(CURDATE()) -- Only include data from the current year
    AND date_visited <= CURDATE() -- Only include data until the current date
GROUP BY 
    semester
ORDER BY 
    date_visited ASC";

$resultSecondSemester = mysqli_query($conn, $querySecondSemester);

// Fetch data for the second semester
$secondSemesterData = array();
while ($row = mysqli_fetch_assoc($resultSecondSemester)) {
    $secondSemesterData[$row['semester']] = $row['count'];
}

// Combine data for both semesters
$semesterData = array_merge($firstSemesterData, $secondSemesterData);

// Ensure both semesters are present in the data, even if one has zero count
$semesters = array_keys($semesterData);
foreach ($semesters as $semester) {
    if (!isset($semesterData[$semester])) {
        $semesterData[$semester] = 0;
    }
}

$data = array(
    "Semester" => $semesterData
);

header('Content-Type: application/json');
echo json_encode($data);
?>
