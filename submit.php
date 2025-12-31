<?php
include 'db.php'; // connect to MySQL

// Get form data
$full_name = $_POST['full_name'];
$email = $_POST['email'];
$job_id = $_POST['job_id'];

// Handle file upload
$resume = "";
if(isset($_FILES['resume']) && $_FILES['resume']['error'] == 0){
    $target_dir = "resumes/"; // make sure this folder exists
    if(!is_dir($target_dir)){
        mkdir($target_dir, 0777, true); // create folder if it doesn't exist
    }
    $file_name = basename($_FILES['resume']['name']);
    $target_file = $target_dir . time() . "_" . $file_name; // unique file name
    if(move_uploaded_file($_FILES['resume']['tmp_name'], $target_file)){
        $resume = $target_file; // store path in DB
    } else {
        echo "Failed to upload resume.";
        exit();
    }
}

// Insert into applications table
$sql = "INSERT INTO applications (full_name, email, job_id, resume_link) 
        VALUES ('$full_name', '$email', '$job_id', '$resume')";

if ($conn->query($sql) === TRUE) {
    echo "<h3>Application submitted successfully!</h3>";
    echo "<a href='index.html'>Go back to Home</a>";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
