<?php
include "../db.php";
$id = $_GET['id'];

$message = "";
 
$get = mysqli_query($conn, "SELECT * FROM services WHERE service_id = $id");
$service = mysqli_fetch_assoc($get);
 
if (isset($_POST['update'])) {
  $name = $_POST['service_name'];
  $desc = $_POST['description'];
  $rate = $_POST['hourly_rate'];
  $active = $_POST['is_active'];
 
  mysqli_query($conn, "UPDATE services
    SET service_name='$name', description='$desc', hourly_rate='$rate', is_active='$active'
    WHERE service_id=$id");
 
  header("Location: services_list.php");
  exit;
}
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Edit Service</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../styles.css"></head>
<body>
<?php include "../nav.php"; ?>

<div class="container">
    <div class="page-header">
      <h1>Edit Service</h1>
    </div>

    <div class="form-card">
      <?php if ($message): ?>
        <div class="alert alert-danger mb-4"><?php echo $message; ?></div>
      <?php endif; ?>

      <form method="post">
        <div class="form-group">
          <label>Service Name*</label>
          <input type="text" name="service_name" class="form-control" value="<?php echo $service['service_name']; ?>"
            placeholder="Enter service name">
        </div>

        <div class="form-group">
          <label>Description*</label>
          <textarea name="description" class="form-control"><?php echo $service['description']; ?></textarea>
        </div>

        <div class="form-group">
          <label>Hourly Rate</label>
          <input type="text" name="hourly_rate" class="form-control" value="<?php echo $service['hourly_rate']; ?>"
            placeholder="Enter hourly rate">
        </div>

        <div class="form-group">
          <label>Active</label>
          <select name="is_active" class="form-control">
            <option value="1" <?php if($service['is_active']==1) echo "selected"; ?>>Yes</option>
            <option value="0" <?php if($service['is_active']==0) echo "selected"; ?>>No</option>
          </select>
        </div>

        <div style="margin-top: 1rem;">
          <button type="submit" name="update" class="btn btn-primary" style="width: 100%;">Update Service</button>
        </div>
        <div style="margin-top: 1rem; text-align: center;">
          <a href="services_list.php" class="nav-item">Back to List</a>
        </div>
      </form>
    </div>
</div>
</body>
</html>