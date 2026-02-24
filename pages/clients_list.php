<?php
include "../db.php";
$result = mysqli_query($conn, "SELECT * FROM clients ORDER BY client_id DESC");
?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>Clients</title>
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
        <h1>Clients</h1>
        <a href="clients_add.php" class="btn btn-primary">+ Add Client</a>
      </div>
    </div>

    <div class="table-container">
      <table class="data-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th class="text-right">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
              <td><?php echo $row['client_id']; ?></td>
              <td><strong><?php echo $row['full_name']; ?></strong></td>
              <td><?php echo $row['email']; ?></td>
              <td><?php echo $row['phone']; ?></td>
              <td class="text-right">
                <a href="clients_edit.php?id=<?php echo $row['client_id']; ?>" class="btn btn-secondary"
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