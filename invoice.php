<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'db.php';

$userId = $_SESSION['id'];
$action = $_GET['action'] ?? '';
$orderId = $_GET['order_id'] ?? 0;

$db = db();

// Get order details
$qr = $db->query("SELECT orders.orderid, users.id, users.name, orders.orderamt, orders.status, orders.orderdate, orderdetail.prodid, orderdetail.prodname, orderdetail.qty, orderdetail.price, orderdetail.amount FROM orders JOIN users ON orders.custid = users.id JOIN orderdetail ON orders.orderid = orderdetail.orderid WHERE orders.orderid = '$orderId' AND custid = '$userId'");

if ($qr->num_rows === 0) {
    return false;
}

$orderData = [];
while ($row = $qr->fetch_assoc()) {
    if (empty($orderData)) {
        $orderData = [
            'orderid' => $row['orderid'],
            'name' => $row['name'],
            'orderamt' => $row['orderamt'],
            'status' => $row['status'],
            'orderdate' => $row['orderdate'],
            'items' => []
        ];
    }
    $orderData['items'][] = [
        'prodname' => $row['prodname'],
        'qty' => $row['qty'],
        'price' => $row['price'],
        'amount' => $row['amount']
    ];
}

// print_r($orderData);

if (! $orderData) {
    die('Order not found or you do not have permission to view it');
}

switch ($action) {
    case 'view':
        displayInvoice($orderData);
        break;

    case 'download':
        generatePdfInvoice($orderData, 'D');
        break;

    case 'print':
        generatePdfInvoice($orderData, 'I');
        break;

    default:
        die('Invalid action');
}

function displayInvoice($orderData)
{
?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>Invoice #<?php echo $orderData['orderid']; ?></title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>

    <body>
        <div class="container mt-4">
            <div class="invoice-container">
                <div class="text-center mb-4">
                    <h1>Ogani Store</h1>
                    <p>k-119 Main Road Azadpur New Delhi , Delhi</p>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <h3>Invoice</h3>
                        <p><strong>Invoice #:</strong> <?php echo $orderData['orderid']; ?></p>
                        <p><strong>Date:</strong> <?php echo date('M j, Y', strtotime($orderData['orderdate'])) ?></p>
                    </div>
                    <div class="col-md-6 text-end">
                        <h3>Customer</h3>
                        <p><strong>Name:</strong> <?php echo $orderData['name']; ?></p>
                    </div>
                </div>

                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orderData['items'] as $item): ?>
                            <tr>
                                <td><?php echo $item['prodname']; ?></td>
                                <td><?php echo $item['qty']; ?></td>
                                <td>₹<?php echo number_format($item['price'], 2); ?></td>
                                <td>₹<?php echo number_format($item['amount'], 2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end"><strong>Total:</strong></td>
                            <td>₹<?php echo number_format($orderData['orderamt'], 2); ?></td>
                        </tr>
                    </tfoot>
                </table>

                <div class="mt-4">
                    <h5>Status</h5>
                    <p><?php echo ucfirst($orderData['status']); ?></p>
                </div>

                <div class="mt-5 pt-4 border-top text-center">
                    <p>Thank you for your order!</p>
                </div>

                <div class="no-print mt-3">
                    <button onclick="window.print()" class="btn btn-primary">
                        <i class="fas fa-print"></i> Print Invoice
                    </button>
                    <a href="invoice.php?action=download&order_id=<?php echo $orderData['orderid']; ?>"
                        class="btn btn-success">
                        <i class="fas fa-download"></i> Download PDF
                    </a>
                </div>
            </div>
        </div>
    </body>

    </html>
<?php
}

function generatePdfInvoice($orderData, $output = 'D') {
    
    require_once './tcpdf_6_3_2/tcpdf/tcpdf.php';

    // Create new PDF document with proper Unicode support
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    
    // Set document information
    $pdf->SetCreator('Ogani');
    $pdf->SetTitle('Invoice #' . $orderData['orderid']);
    
    // Add a page
    $pdf->AddPage();
    
    // Set font with Unicode support
    $pdf->SetFont('dejavusans', '', 10); // DejaVu Sans supports most Unicode characters
    
    // HTML content with proper Rupee symbol encoding
    $html = '
    <h1>Invoice #' . $orderData['orderid'] . '</h1>
    <p>Date: ' . $orderData['orderdate'] . '</p>
    <p>Customer: ' . $orderData['name'] . '</p>
    
    <table border="1" cellpadding="5">
        <tr>
            <th>Product</th>
            <th>Qty</th>
            <th>Price</th>
            <th>Total</th>
        </tr>';

    foreach ($orderData['items'] as $item) {
        $html .= '
        <tr>
            <td>' . $item['prodname'] . '</td>
            <td>' . $item['qty'] . '</td>
            <td>₹ ' . number_format($item['price'], 2) . '</td>
            <td>₹ ' . number_format($item['amount'], 2) . '</td>
        </tr>';
    }

    $html .= '
        <tr>
            <td colspan="3" align="right"><strong>Total:</strong></td>
            <td><strong>₹ ' . number_format($orderData['orderamt'], 2) . '</strong></td>
        </tr>
    </table>
    <p>Status: ' . ucfirst($orderData['status']) . '</p>
    <p>Thank you for your order!</p>';

    // Output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');
    
    // Close and output PDF document
    $pdf->Output('invoice_' . $orderData['orderid'] . '.pdf', $output);
    exit;
}
?>