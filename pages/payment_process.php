<?php
include "../db.php";

$booking_id = $_GET['booking_id'];

$booking = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM bookings WHERE booking_id=$booking_id"));

$paidRow = mysqli_fetch_assoc(mysqli_query($conn, "SELECT IFNULL(SUM(amount_paid),0) AS paid FROM payments WHERE booking_id=$booking_id"));
$total_paid = $paidRow['paid'];

$balance = $booking['total_cost'] - $total_paid;
$message = "";

if (isset($_POST['pay'])) {
  $amount = $_POST['amount_paid'];
  $method = $_POST['method'];

  if ($amount <= 0) {
    $message = "Invalid amount!";
  } else if ($amount > $balance) {
    $message = "Amount exceeds balance!";
  } else {
    // 1) Insert payment
    mysqli_query($conn, "INSERT INTO payments (booking_id, amount_paid, method)
      VALUES ($booking_id, $amount, '$method')");

    // 2) Recompute total paid (after insert)
    $paidRow2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT IFNULL(SUM(amount_paid),0) AS paid FROM payments WHERE booking_id=$booking_id"));
    $total_paid2 = $paidRow2['paid'];

    // 3) Recompute new balance
    $new_balance = $booking['total_cost'] - $total_paid2;

    // 4) If fully paid, update booking status to PAID
    if ($new_balance <= 0.009) {
      mysqli_query($conn, "UPDATE bookings SET status='PAID' WHERE booking_id=$booking_id");
    }

    header("Location: bookings_list.php");
    exit;
  }
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Process Payment</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
<?php include "../nav.php"; ?>

<div class="container">
    <div class="page-header">
        <h1>Process Payment (Booking #<?php echo $booking_id; ?>)</h1>
    </div>

    <?php if ($message): ?>
        <div class="alert alert-danger"><?php echo $message; ?></div>
    <?php endif; ?>

    <div class="stat-grid">
        <div class="stat-card">
            <span class="stat-label">Total Cost</span>
            <span class="stat-value">₱<?php echo number_format($booking['total_cost'],2); ?></span>
        </div>
        <div class="stat-card">
            <span class="stat-label">Total Paid</span>
            <span class="stat-value">₱<?php echo number_format($total_paid,2); ?></span>
        </div>
        <div class="stat-card revenue">
            <span class="stat-label">Balance</span>
            <span class="stat-value">₱<?php echo number_format($balance,2); ?></span>
        </div>
    </div>

    <div class="form-card">
        <form method="post">
            <div class="form-group">
                <label>Amount Paid</label>
                <input type="number" name="amount_paid" step="0.01" class="form-control" value="<?php echo number_format($balance, 2, '.', ''); ?>" required>
            </div>

            <div class="form-group">
                <label>Method</label>
                <select name="method" class="form-control">
                    <option value="CASH">CASH</option>
                    <option value="GCASH">GCASH</option>
                    <option value="CARD">CARD</option>
                </select>
            </div>

            <button type="submit" name="pay" class="btn btn-primary">Save Payment</button>
            <a href="bookings_list.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

</body>
</html>
 