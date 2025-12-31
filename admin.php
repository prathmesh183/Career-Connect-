<?php
include 'db.php'; // connect to MySQL

// Handle deletion
if(isset($_GET['delete_id'])){
    $id = $_GET['delete_id'];
    $conn->query("DELETE FROM applications WHERE application_id = $id");
    header("Location: admin.php");
}

// Handle status update
if(isset($_POST['update_id'])){
    $id = $_POST['update_id'];
    $status = $_POST['status'];
    $conn->query("UPDATE applications SET status='$status' WHERE application_id=$id");
    header("Location: admin.php");
}

// Fetch all applications
$result = $conn->query("SELECT a.*, j.title AS job_title FROM applications a 
                        LEFT JOIN jobs j ON a.job_id = j.job_id");

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin - Career Connect</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h2 class="mb-4">Admin Dashboard - Applications</h2>
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>ID</th>
        <th>Full Name</th>
        <th>Email</th>
        <th>Job</th>
        <th>Resume</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = $result->fetch_assoc()) { ?>
      <tr>
        <td><?php echo $row['application_id']; ?></td>
        <td><?php echo $row['full_name']; ?></td>
        <td><?php echo $row['email']; ?></td>
        <td><?php echo $row['job_title']; ?></td>
        <td>
          <?php if($row['resume_link']) { ?>
            <a href="<?php echo $row['resume_link']; ?>" target="_blank">View</a>
          <?php } else { echo "No Resume"; } ?>
        </td>
        <td>
          <form method="POST" style="display:inline-block;">
            <input type="hidden" name="update_id" value="<?php echo $row['application_id']; ?>">
            <select name="status" class="form-select" onchange="this.form.submit()">
              <option value="Pending" <?php if($row['status']=='Pending') echo 'selected'; ?>>Pending</option>
              <option value="Selected" <?php if($row['status']=='Selected') echo 'selected'; ?>>Selected</option>
              <option value="Rejected" <?php if($row['status']=='Rejected') echo 'selected'; ?>>Rejected</option>
            </select>
          </form>
        </td>
        <td>
          <a href="admin.php?delete_id=<?php echo $row['application_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
        </td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
</body>
</html>
