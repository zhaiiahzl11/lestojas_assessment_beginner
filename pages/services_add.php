<?php
include "../db.php";

$message = "";

if (isset($_POST['save'])) {
  $service_name = $_POST['service_name'];
  $description = $_POST['description'];
  $hourly_rate = $_POST['hourly_rate'];
  $is_active = $_POST['is_active'];

  // simple validation
  if ($service_name == "" || $hourly_rate == "") {
    $message = "Service name and hourly rate are required!";
  } else if (!is_numeric($hourly_rate) || $hourly_rate <= 0) {
    $message = "Hourly rate must be a number greater than 0.";
  } else {
    $sql = "INSERT INTO services (service_name, description, hourly_rate, is_active)
            VALUES ('$service_name', '$description', '$hourly_rate', '$is_active')";
    mysqli_query($conn, $sql);

    header("Location: services_list.php");
    exit;
  }
}
?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>Add Service</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../styles.css">
</head>

<body>
  <?php include "../nav.php"; ?>

  <div class="container">
    <div class="page-header">
      <h1>Add Service</h1>
    </div>

    <div class="form-card">
      <?php if ($message): ?>
        <div class="alert alert-danger mb-4"><?php echo $message; ?></div>
      <?php endif; ?>

      <form method="post">
        <div class="form-group">
          <label>Service Name*</label>
          <input type="text" name="service_name" class="form-control" placeholder="e.g. Graphic Design" required>
        </div>

        <div class="form-group">
          <label>Description</label>
          <textarea name="description" class="form-control" rows="4"
            placeholder="Brief description of the service"></textarea>
        </div>

        <div class="form-group">
          <label>Hourly Rate (₱)*</label>
          <input type="text" name="hourly_rate" class="form-control" placeholder="0.00" required>
        </div>

        <div class="form-group">
          <label>Active?</label>
          <select name="is_active" class="form-control">
            <option value="1">Yes</option>
            <option value="0">No</option>
          </select>
        </div>

        <div style="margin-top: 2rem;">
          <button type="submit" name="save" class="btn btn-primary" style="width: 100%;">Save Service</button>
        </div>

        <div style="margin-top: 1.5rem; text-align: center;">
          <a href="services_list.php" class="nav-item">Back to List</a>
        </div>
      </form>
    </div>
  </div>
</body>

</html>