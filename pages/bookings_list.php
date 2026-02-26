<?php
include "../db.php";

$sql = "
SELECT b.*, c.full_name AS client_name, s.service_name
FROM bookings b
JOIN clients c ON b.client_id = c.client_id
JOIN services s ON b.service_id = s.service_id
ORDER BY b.booking_id DESC
";
$result = mysqli_query($conn, $sql);
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bookings</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../styles.css">
</head>

<body>
    <?php include "../nav.php"; ?>

    <div class="container">
        <div class="page-header">
            <h1>Bookings</h1>
        </div>

        <div class="mb-4">
            <a href="bookings_create.php" class="btn btn-primary">+ Create Booking</a>
        </div>

        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Client</th>
                        <th>Service</th>
                        <th>Date</th>
                        <th>Hours</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($b = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo $b['booking_id']; ?></td>
                            <td><?php echo $b['client_name']; ?></td>
                            <td><?php echo $b['service_name']; ?></td>
                            <td><?php echo $b['booking_date']; ?></td>
                            <td><?php echo $b['hours']; ?></td>
                            <td>₱<?php echo number_format($b['total_cost'], 2); ?></td>
                            <td><?php echo $b['status']; ?></td>
                            <td>
                                <a href="payment_process.php?booking_id=<?php echo $b['booking_id']; ?>" class="btn btn-secondary">Process Payment</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>