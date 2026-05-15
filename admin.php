<?php
/**
 * THE AI CONTENT MACHINE - ADMIN DASHBOARD
 * Simple, secure way to track sales and emails.
 */

// Simple password protection
$admin_password = 'admin123_change_me'; // CHANGE THIS IMMEDIATELY

if (!isset($_SERVER['PHP_AUTH_USER']) || $_SERVER['PHP_AUTH_PW'] != $admin_password) {
    header('WWW-Authenticate: Basic realm="Admin Dashboard"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Unauthorized access.';
    exit;
}

$sales_file = 'sales.csv';
$total_revenue = 0;
$sales_count = 0;
$sales_data = [];

if (file_exists($sales_file)) {
    if (($handle = fopen($sales_file, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $sales_data[] = $data;
            $total_revenue += (float)$data[4];
            $sales_count++;
        }
        fclose($handle);
    }
}

// Reverse to show latest sales first
$sales_data = array_reverse($sales_data);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard — The AI Content Machine</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #F59E0B; --bg: #0F172A; --card: #1E293B; --text: #F8FAFC; }
        body { background: var(--bg); color: var(--text); font-family: 'Inter', sans-serif; padding: 40px; margin: 0; }
        .container { max-width: 1000px; margin: 0 auto; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px; }
        .stats-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 40px; }
        .stat-card { background: var(--card); padding: 30px; border-radius: 16px; border: 1px solid rgba(255,255,255,0.1); }
        .stat-val { font-size: 32px; font-weight: 800; color: var(--primary); }
        .stat-label { font-size: 14px; opacity: 0.6; text-transform: uppercase; letter-spacing: 1px; }
        
        table { width: 100%; border-collapse: collapse; background: var(--card); border-radius: 16px; overflow: hidden; }
        th { background: rgba(255,255,255,0.05); text-align: left; padding: 15px; font-size: 14px; opacity: 0.7; }
        td { padding: 15px; border-bottom: 1px solid rgba(255,255,255,0.05); font-size: 14px; }
        tr:hover { background: rgba(255,255,255,0.02); }
        .badge { background: #059669; color: #FFF; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: 700; }
    </style>
</head>
<body>

    <div class="container">
        <div class="header">
            <h1>Admin Dashboard</h1>
            <div class="badge">LIVE TRACKING</div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">Total Revenue</div>
                <div class="stat-val">$<?php echo number_format($total_revenue, 2); ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Total Sales</div>
                <div class="stat-val"><?php echo $sales_count; ?></div>
            </div>
        </div>

        <h2>Recent Sales & Email Leads</h2>
        <table>
            <thead>
                <tr>
                    <th>Date/Time</th>
                    <th>Customer Email</th>
                    <th>Location</th>
                    <th>Source</th>
                    <th>Amount</th>
                    <th>Order ID</th>
                    <th>IP Address</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($sales_data)): ?>
                    <tr><td colspan="7" style="text-align:center; padding: 40px;">No sales recorded yet. Start driving traffic!</td></tr>
                <?php else: ?>
                    <?php foreach ($sales_data as $row): ?>
                    <tr>
                        <td><?php echo $row[0]; ?></td>
                        <td style="font-weight:600;"><?php echo $row[1]; ?></td>
                        <td><span class="badge" style="background:#4B5563;"><?php echo $row[2]; ?></span></td>
                        <td style="font-size: 11px; opacity: 0.6; max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><?php echo $row[3]; ?></td>
                        <td style="color:var(--primary); font-weight:700;"><?php echo $row[5] . ' ' . $row[4]; ?></td>
                        <td style="font-family: monospace; opacity: 0.7;"><?php echo $row[6]; ?></td>
                        <td style="opacity: 0.5;"><?php echo $row[7]; ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>
</html>
