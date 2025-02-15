<?php
require_once('vendor/autoload.php');
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

// Create new PDF document
$pdf = new TCPDF();

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('SajmustafaKe');
$pdf->SetTitle('Daily Financial Report');
$pdf->SetSubject('Report');
$pdf->SetKeywords('TCPDF, PDF, report, financial, daily');

// Set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'Daily Financial Report', "Date: $date");

// Set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// Set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// Set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// Set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Add a page
$pdf->AddPage();

// Set font
$pdf->SetFont('helvetica', '', 12);

// Add content
$html = '<h1>Daily Financial Report - ' . $date . '</h1>';

$html .= '<h2>Sales</h2>';
$html .= '<table border="1" cellpadding="4"><tr><th>Branch</th><th>Amount</th></tr>';
while ($row = $sales->fetch_assoc()) {
    $html .= '<tr><td>' . $row['branch'] . '</td><td>' . $row['amount'] . '</td></tr>';
}
$html .= '</table>';

$html .= '<h2>Bank Balances</h2>';
$html .= '<table border="1" cellpadding="4"><tr><th>Balance</th></tr>';
while ($row = $bank_balances->fetch_assoc()) {
    $html .= '<tr><td>' . $row['balance'] . '</td></tr>';
}
$html .= '</table>';

$html .= '<h2>Accounts Payable</h2>';
$html .= '<table border="1" cellpadding="4"><tr><th>Amount</th></tr>';
while ($row = $accounts_payable->fetch_assoc()) {
    $html .= '<tr><td>' . $row['amount'] . '</td></tr>';
}
$html .= '</table>';

$html .= '<h2>Accounts Receivable</h2>';
$html .= '<table border="1" cellpadding="4"><tr><th>Amount</th></tr>';
while ($row = $accounts_receivable->fetch_assoc()) {
    $html .= '<tr><td>' . $row['amount'] . '</td></tr>';
}
$html .= '</table>';

$html .= '<h2>Posted Cheques Released</h2>';
$html .= '<table border="1" cellpadding="4"><tr><th>Amount</th></tr>';
while ($row = $posted_cheques_released->fetch_assoc()) {
    $html .= '<tr><td>' . $row['amount'] . '</td></tr>';
}
$html .= '</table>';

$html .= '<h2>Posted Cheques Received</h2>';
$html .= '<table border="1" cellpadding="4"><tr><th>Amount</th></tr>';
while ($row = $posted_cheques_received->fetch_assoc()) {
    $html .= '<tr><td>' . $row['amount'] . '</td></tr>';
}
$html .= '</table>';

$html .= '<h2>Matters Arising</h2>';
$html .= '<table border="1" cellpadding="4"><tr><th>Description</th></tr>';
while ($row = $matters_arising->fetch_assoc()) {
    $html .= '<tr><td>' . $row['description'] . '</td></tr>';
}
$html .= '</table>';

// Output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// Close and output PDF document
$pdf->Output('daily_report.pdf', 'I');
?>