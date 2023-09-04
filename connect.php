<?php
	$name = $_POST['name'];
	$email = $_POST['email'];
	$mobile = $_POST['mobile'];
	$address = $_POST['address'];

	// Database connection
	$conn = new mysqli('localhost','root','','phptask');
  if($conn->connect_error){
		echo "$conn->connect_error";
		die("Connection Failed : ". $conn->connect_error);
	} 
// SQL query to create a table
$table = "CREATE TABLE student (
    student_id INT PRIMARY KEY AUTO_INCREMENT,
    name       VARCHAR(50) NOT NULL,
    email VARCHAR(100),
    mobile VARCHAR(15),
    address VARCHAR(255)
)";
// add country_code function

function updatemobile($mobile){
  $country_Code="+1";
  return $country_Code.$mobile;
}

$mobile=updatemobile($mobile);

function updatename($conn) {
  // SQL query to update the name for student with ID 1
  $sql = "UPDATE student SET name = 'laxmi' WHERE student_id = 1";

  // Execute the SQL query
  if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
  } else {
    echo "Error updating record: " . $conn->error;
  }
}
// add column
function add_col() {
  global $conn;

  // SQL statement to add a new column
  $add = "ALTER TABLE student ADD COLUMN gender VARCHAR(50)";

  // SQL statement to update the 'gender' column based on 'address'
  $update = "UPDATE student SET gender = 'male' WHERE address LIKE '%r%'";

  if ($conn->query($add) === TRUE) {
      if ($conn->query($update) === TRUE) {
          echo "New column added and data updated successfully";
      } else {
          echo "Error updating data: " . $conn->error;
      }
  } else {
      echo "Error adding new column: " . $conn->error;
  }
}

add_col();

$sql = "INSERT INTO student (name,email, mobile, address) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $name, $email, $mobile, $address);
if ($stmt->execute()) {
    echo "Record inserted successfully.";
} 
else {
    echo "Error: " . $stmt->error;
  }
$stmt->close();
$conn->close();
?>
