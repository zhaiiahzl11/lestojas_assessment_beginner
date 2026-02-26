<?php
include "../db.php";

$message = "";

// ASSIGN TOOL
if (isset($_POST['assign'])) {
  $booking_id = $_POST['booking_id'];
  $tool_id = $_POST['tool_id'];
  $qty = $_POST['qty_used'];

  $toolRow = mysqli_fetch_assoc(mysqli_query($conn, "SELECT quantity_available FROM tools WHERE tool_id=$tool_id"));

  if ($qty > $toolRow['quantity_available']) {
    $message = "Not enough available tools!";
  } else {
    mysqli_query($conn, "INSERT INTO booking_tools (booking_id, tool_id, qty_used)
      VALUES ($booking_id, $tool_id, $qty)");

    mysqli_query($conn, "UPDATE tools SET quantity_available = quantity_available - $qty WHERE tool_id=$tool_id");

    $message = "Tool assigned successfully!";
  }
}

$tools = mysqli_query($conn, "SELECT * FROM tools ORDER BY tool_name ASC");
$bookings = mysqli_query($conn, "SELECT booking_id FROM bookings ORDER BY booking_id DESC");
?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>Tools / Inventory</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../styles.css">
</head>

<body>
  <?php include "../nav.php"; ?>

  <div class="container">
    <div class="page-header">
      <h1>Tools / Inventory</h1>
    </div>

    <?php if ($message): ?>
      <div class="alert <?php echo (strpos($message, 'success') !== false) ? 'alert-success' : 'alert-danger'; ?> mb-4">
        <?php echo $message; ?>
      </div>
    <?php endif; ?>

    <div class="stat-grid">
      <div class="stat-card">
        <span class="stat-label">Inventory Overview</span>
        <span class="stat-value">Stock Management</span>
      </div>
    </div>

    <h3 class="mb-4">Available Tools</h3>
    <div class="table-container mb-4">
      <table class="data-table">
        <thead>
          <tr>
            <th>Name</th>
            <th>Total</th>
            <th>Available</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($t = mysqli_fetch_assoc($tools)) { ?>
            <tr>
              <td><?php echo $t['tool_name']; ?></td>
              <td><?php echo $t['quantity_total']; ?></td>
              <td><?php echo $t['quantity_available']; ?></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>

    <div class="page-header mt-4">
      <h3>Assign Tool to Booking</h3>
    </div>

    <div class="form-card">
      <form method="post">
        <div class="form-group">
          <label>Booking ID</label>
          <select name="booking_id" class="form-control">
            <?php while ($b = mysqli_fetch_assoc($bookings)) { ?>
              <option value="<?php echo $b['booking_id']; ?>">#<?php echo $b['booking_id']; ?></option>
            <?php } ?>
          </select>
        </div>

        <div class="form-group">
          <label>Tool</label>
          <select name="tool_id" class="form-control">
            <?php
            $tools2 = mysqli_query($conn, "SELECT * FROM tools ORDER BY tool_name ASC");
            while ($t2 = mysqli_fetch_assoc($tools2)) {
              ?>
              <option value="<?php echo $t2['tool_id']; ?>">
                <?php echo $t2['tool_name']; ?> (Avail: <?php echo $t2['quantity_available']; ?>)
              </option>
            <?php } ?>
          </select>
        </div>

        <div class="form-group">
          <label>Qty Used</label>
          <input type="number" name="qty_used" min="1" value="1" class="form-control">
        </div>

        <button type="submit" name="assign" class="btn btn-primary">Assign Tool</button>
      </form>
    </div>
  </div>

</body>

</html>