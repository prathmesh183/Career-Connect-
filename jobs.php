<?php
include 'db.php';

$result = $conn->query("SELECT * FROM jobs");

echo "<h2>Available Jobs</h2>";
echo "<table border='1'>
<tr><th>Title</th><th>Company</th><th>Location</th><th>Salary</th></tr>";

while($row = $result->fetch_assoc()) {
    echo "<tr>
          <td>".$row['title']."</td>
          <td>".$row['company']."</td>
          <td>".$row['location']."</td>
          <td>".$row['salary']."</td>
          </tr>";
}
echo "</table>";

$conn->close();
?>
