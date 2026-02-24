<?php
include "../db.php";
$result = mysqli_query($conn, "SELECT * FROM services ORDER BY service_id DESC");
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Services</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../styles.css">
</head>
<body>
<?php include "../nav.php"; ?>
 

<div class="container">
    <div class="page-header">
      <div style="display: flex; justify-content: space-between; align-items: center;">
        <h1>Services</h1>
      </div>
    </div>

    <div class="table-container">
      <table class="data-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Rate</th>
            <th>Active</th>
            <th class="text-right">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
              <td><?php echo $row['service_id']; ?></td>
              <td><strong><?php echo $row['service_name']; ?></strong></td>
              <td>₱<?php echo number_format($row['hourly_rate'],2); ?></td>
              <td><?php echo $row['is_active'] ? "Yes" : "No"; ?></td>
              <td class="text-right">
                <a href="services_edit.php?id=<?php echo $row['service_id']; ?>" class="btn btn-secondary"
                  style="padding: 0.4rem 0.8rem; font-size: 0.8rem;">Edit</a>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
    </div>
</body>
</html>
 