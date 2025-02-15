<?php
include 'db.php';

// Fetch data for the current day
$date = date('Y-m-d');

$sales = $conn->query("SELECT * FROM sales WHERE date='$date'");
$bank_balances = $conn->query("SELECT * FROM bank_balances WHERE date='$date'");
$accounts_payable = $conn->query("SELECT * FROM accounts_payable WHERE date='$date'");
$accounts_receivable = $conn->query("SELECT * FROM accounts_receivable WHERE date='$date'");
$posted_cheques_released = $conn->query("SELECT * FROM posted_cheques WHERE date='$date' AND type='released'");
$posted_cheques_received = $conn->query("SELECT * FROM posted_cheques WHERE date='$date' AND type='received'");
$matters_arising = $conn->query("SELECT * FROM matters_arising WHERE date='$date'");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daily Report</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Daily Financial Report - <?php echo $date; ?></h1>

    <h2>Sales</h2>
    <table>
        <tr>
            <th>Branch</th>
            <th>Amount</th>
        </tr>
        <?php while($row = $sales->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['branch']; ?></td>
            <td><?php echo $row['amount']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

    <h2>Bank Balances</h2>
    <table>
        <tr>
            <th>Balance</th>
        </tr>
        <?php while($row = $bank_balances->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['balance']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

    <h2>Accounts Payable</h2>
    <table>
        <tr>
            <th>Amount</th>
        </tr>
        <?php while($row = $accounts_payable->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['amount']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

    <h2>Accounts Receivable</h2>
    <table>
        <tr>
            <th>Amount</th>
        </tr>
        <?php while($row = $accounts_receivable->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['amount']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

    <h2>Posted Cheques Released</h2>
    <table>
        <tr>
            <th>Amount</th>
        </tr>
        <?php while($row = $posted_cheques_released->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['amount']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

    <h2>Posted Cheques Received</h2>
    <table>
        <tr>
            <th>Amount</th>
        </tr>
        <?php while($row = $posted_cheques_received->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['amount']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

    <h2>Matters Arising</h2>
    <table>
        <tr>
            <th>Description</th>
        </tr>
        <?php while($row = $matters_arising->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['description']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

    <form action="export_pdf.php" method="post">
        <button type="submit">Export to PDF</button>
    </form>
</body>
</html>