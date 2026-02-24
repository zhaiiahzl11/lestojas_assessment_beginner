<?php
include "../db.php";

$message = "";
 
if (isset($_POST['save'])) {
  $full_name = $_POST['full_name'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $address = $_POST['address'];
 
  if ($full_name == "" || $email == "") {
    $message = "Name and Email are required!";
  } else {
    $sql = "INSERT INTO clients (full_name, email, phone, address)
            VALUES ('$full_name', '$email', '$phone', '$address')";
    mysqli_query($conn, $sql);
    header("Location: clients_list.php");
    exit;
  }
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Add Client</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
<?php include "../nav.php"; ?>

<div class="container">
    <div class="page-header">
        <h1>Add Client</h1>
    </div>

    <div class="form-card">
        <?php if ($message): ?>
            <div class="alert alert-danger mb-4"><?php echo $message; ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="form-group">
                <label>Full Name*</label>
                <input type="text" name="full_name" class="form-control" placeholder="Enter full name">
            </div>

            <div class="form-group">
                <label>Email*</label>
                <input type="email" name="email" class="form-control" placeholder="Enter email address">
            </div>

            <div class="form-group">
                <label>Phone</label>
                <input type="text" name="phone" class="form-control" placeholder="Enter phone number">
            </div>

            <div class="form-group">
                <label>Address</label>
                <input type="text" name="address" class="form-control" placeholder="Enter address">
            </div>

            <div style="margin-top: 1rem;">
                <button type="submit" name="save" class="btn btn-primary" style="width: 100%;">Save Client</button>
            </div>
            <div style="margin-top: 1rem; text-align: center;">
                <a href="clients_list.php" class="nav-item">Back to List</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>