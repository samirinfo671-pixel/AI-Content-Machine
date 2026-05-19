<?php
/**
 * THE AI CONTENT MACHINE - SUCCESS REDIRECT & EMAIL DELIVERY
 */

// 1. EXTRACT DATA FROM REDIRECT
$email = isset($_GET['email']) ? urldecode($_GET['email']) : '';
$order = isset($_GET['order']) ? strip_tags($_GET['order']) : 'N/A';
$sum   = isset($_GET['sum'])   ? strip_tags($_GET['sum'])   : '27.00';
$cur   = isset($_GET['cur'])   ? strip_tags($_GET['cur'])   : 'USD';
$hash  = isset($_GET['hash'])  ? strip_tags($_GET['hash'])  : '';

// 2. SECURITY VERIFICATION (The "Best Way")
$secret_key = 'adcf73c0c1bdcce5423c269698c0d960'; 
$check_hash = hash('sha256', $order . $secret_key);

if ($hash !== $check_hash || empty($email)) {
    // Redirect back to home if hash is invalid (protects against manual access)
    header("Location: index.html");
    exit();
}

// 3. SEND WELCOME EMAIL
if (!empty($email)) {
    $to = $email;
    $subject = "Your Order: The AI Content Machine Bundle 🤖";
    $message = "
    <html>
    <head><title>Your Order Details</title></head>
    <body style='font-family: Arial, sans-serif; line-height: 1.6; color: #333;'>
      <div style='max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eee; border-radius: 10px;'>
        <h2 style='color: #7C3AED;'>Welcome to the Machine!</h2>
        <p>Thank you for your purchase of <strong>The AI Content Machine Bundle</strong>. Your journey to automating your content and scaling your income starts now.</p>
        
        <div style='background: #F9FAFB; padding: 20px; border-radius: 8px; margin: 20px 0;'>
          <p style='margin: 0;'><strong>Order Number:</strong> $order</p>
          <p style='margin: 0;'><strong>Amount Paid:</strong> $cur $sum</p>
        </div>

        <h3>🚀 Access Your Files:</h3>
        <p>You can access your digital products at any time using the links below:</p>
        <p><a href='https://{$_SERVER['HTTP_HOST']}/book.html' style='display: inline-block; background: #7C3AED; color: #fff; padding: 12px 24px; text-decoration: none; border-radius: 5px;'>Download Your Playbook</a></p>
        <p><a href='https://{$_SERVER['HTTP_HOST']}/bonuses.html' style='display: inline-block; border: 1px solid #7C3AED; color: #7C3AED; padding: 12px 24px; text-decoration: none; border-radius: 5px;'>Access Bonus Vault</a></p>

        <p style='margin-top: 30px; font-size: 12px; color: #999;'>Need help? Reply to this email or contact support@Theaicontentmachine.co</p>
      </div>
    </body>
    </html>
    ";

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: The AI Content Machine <Support@Theaicontentmachine.co>" . "\r\n";

    mail($to, $subject, $message, $headers);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to the 5% — The AI Content Machine</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700;900&family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #F59E0B;
            --bg: #0F172A;
            --card-bg: #1E293B;
            --text: #F8FAFC;
            --text-muted: #94A3B8;
        }

        body {
            background-color: var(--bg);
            color: var(--text);
            font-family: 'Inter', sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            text-align: center;
            padding: 20px;
        }

        .success-card {
            background: var(--card-bg);
            padding: 60px 40px;
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            max-width: 600px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .icon {
            font-size: 64px;
            margin-bottom: 24px;
        }

        h1 {
            font-family: 'Poppins', sans-serif;
            font-size: 36px;
            font-weight: 900;
            margin: 0 0 16px;
            background: linear-gradient(135deg, #FFF 0%, var(--primary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        p {
            font-size: 18px;
            color: var(--text-muted);
            margin-bottom: 40px;
            line-height: 1.6;
        }

        .download-btn {
            display: inline-block;
            background: var(--primary);
            color: #000;
            text-decoration: none;
            padding: 18px 40px;
            border-radius: 12px;
            font-weight: 800;
            font-size: 18px;
            transition: 0.3s;
            margin-bottom: 20px;
        }

        .download-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(245, 158, 11, 0.3);
        }

        .bonus-text {
            font-size: 14px;
            color: var(--primary);
            font-weight: 600;
        }

        .support {
            margin-top: 40px;
            font-size: 14px;
            color: var(--text-muted);
        }

        .support a {
            color: var(--text);
            text-decoration: none;
            font-weight: 600;
        }
    </style>

    <!-- TRACKING PIXELS INITIALIZATION -->
    <script>
        // 1. TikTok Base
        !function (w, d, t) {
            w.TiktokAnalyticsObject = t; var ttq = w[t] = w[t] || []; ttq.methods = ["page", "track", "identify", "instances", "debug", "on", "off", "once", "ready", "alias", "group", "trackWithContext", "withContext"], ttq.setAndDefer = function (t, e) { t.magellan = e, t.instances.push(t) }; for (var e = 0; e < ttq.methods.length; e++)ttq.setAndDefer(ttq, ttq.methods[e]); ttq.instance = function (t) { for (var e = ttq._i[t] || [], n = 0; n < ttq.methods.length; n++)ttq.setAndDefer(e, ttq.methods[n]); return e }, ttq.load = function (e, n) { var o = "https://analytics.tiktok.com/i18n/pixel/events.js"; ttq._i = ttq._i || {}, ttq._i[e] = [], ttq._i[e]._u = o, ttq._t = ttq._t || {}, ttq._t[e] = +new Date, ttq._o = ttq._o || {}, ttq._o[e] = n; var i = d.createElement("script"); i.type = "text/javascript", i.async = !0, i.src = o + "?sdkid=" + e + "&lib=" + t; var a = d.getElementsByTagName("script")[0]; a.parentNode.insertBefore(i, a) };
            ttq.load('YOUR_TIKTOK_PIXEL_ID_HERE'); // <-- REPLACE WITH YOUR TIKTOK PIXEL ID
            ttq.page();
        }(window, document, 'ttq');

        // 2. Meta Pixel Code
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '763430750189229');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=763430750189229&ev=PageView&noscript=1"
    /></noscript>
</head>
<body>

    <div class="success-card">
        <div class="icon">🚀</div>
        <h1>Welcome to the Machine.</h1>
        <p>Your payment was successful. You are now officially part of the 5% of creators using leverage to win. Your journey to the 2-hour work week starts right here.</p>
        
        <a href="book.html" class="download-btn">DOWNLOAD YOUR PLAYBOOK</a>
        <a href="bonuses.html" class="download-btn" style="background: transparent; border: 2px solid var(--primary); color: var(--primary); margin-left: 10px;">ACCESS BONUS VAULT</a>
        
        <div class="bonus-text" style="margin-top: 20px;">Check your email for your receipt and permanent access links!</div>

        <div class="support">
            Need help? Reach out at <a href="mailto:support@Theaicontentmachine.co">Support@Theaicontentmachine.co</a>
        </div>
    </div>

    <!-- CONVERSION TRACKING (FIRE ONLY ON SUCCESS) -->
    <script>
        // 1. Facebook Pixel Purchase
        if (typeof fbq === 'function') {
            fbq('track', 'Purchase', {
                value: <?php echo $sum; ?>,
                currency: '<?php echo $cur; ?>',
                content_name: 'The AI Content Machine Bundle',
                order_id: '<?php echo $order; ?>'
            });
        }

        // 2. TikTok Pixel CompletePayment
        if (typeof ttq === 'function') {
            ttq.track('CompletePayment', {
                contents: [{
                    content_id: 'bundle_01',
                    content_type: 'product',
                    content_name: 'The AI Content Machine Bundle',
                    quantity: 1,
                    price: <?php echo $sum; ?>
                }],
                value: <?php echo $sum; ?>,
                currency: '<?php echo $cur; ?>'
            });
        }

        // 3. Google Ads / GA4 Purchase
        if (typeof gtag === 'function') {
            gtag('event', 'purchase', {
                transaction_id: '<?php echo $order; ?>',
                value: <?php echo $sum; ?>,
                currency: '<?php echo $cur; ?>',
                items: [{
                    item_name: 'The AI Content Machine Bundle',
                    price: <?php echo $sum; ?>,
                    quantity: 1
                }]
            });
        }
    </script>

</body>
</html>
