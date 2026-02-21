<?php
include "db.php";
 
$clients = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM clients"))['c'];
$services = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM services"))['c'];
$bookings = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM bookings"))['c'];
 
$revRow = mysqli_fetch_assoc(mysqli_query($conn, "SELECT IFNULL(SUM(amount_paid),0) AS s FROM payments"));
$revenue = $revRow['s'];
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Dashboard</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="styles.css">
</head>
<body class="dashboard-page">
<?php include "nav.php"; ?>

<div class="container">
  <header class="page-header">
    <h1>Dashboard</h1>
  </header>

  <div class="stat-grid">
    <div class="stat-card">
      <span class="stat-label">Total Clients</span>
      <span class="stat-value"><?php echo $clients; ?></span>
    </div>
    <div class="stat-card">
      <span class="stat-label">Total Services</span>
      <span class="stat-value"><?php echo $services; ?></span>
    </div>
    <div class="stat-card">
      <span class="stat-label">Total Bookings</span>
      <span class="stat-value"><?php echo $bookings; ?></span>
    </div>
    <div class="stat-card revenue">
      <span class="stat-label">Total Revenue</span>
      <span class="stat-value">₱<?php echo number_format($revenue,2); ?></span>
    </div>
  </div>

  <section class="quick-actions">
    <h3>Quick Actions</h3>
    <div class="action-buttons">
      <a href="/assessment_beginner/pages/clients_add.php" class="btn btn-primary">Add Client</a>
      <a href="/assessment_beginner/pages/bookings_create.php" class="btn btn-secondary">Create Booking</a>
    </div>
  </section>
</div>
 
</body>
</html>