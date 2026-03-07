<!DOCTYPE html>
<html>
<head>
    <title>Test CSS Loading</title>
    <base href="<?php echo htmlspecialchars($_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/'); ?>">
    <link rel="stylesheet" href="assets/css/modern-theme.css">
    <style>
        body { padding: 20px; font-family: Arial; }
        .test-box { padding: 20px; margin: 10px 0; border: 2px solid #ccc; }
    </style>
</head>
<body>
    <h1>CSS Loading Test</h1>

    <div class="test-box">
        <h3>Path Information:</h3>
        <p><strong>REQUEST_SCHEME:</strong> <?php echo $_SERVER['REQUEST_SCHEME'] ?? 'N/A'; ?></p>
        <p><strong>HTTP_HOST:</strong> <?php echo $_SERVER['HTTP_HOST'] ?? 'N/A'; ?></p>
        <p><strong>SCRIPT_NAME:</strong> <?php echo $_SERVER['SCRIPT_NAME'] ?? 'N/A'; ?></p>
        <p><strong>Base HREF calculated:</strong> <?php echo htmlspecialchars($_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/'); ?></p>
        <p><strong>Expected CSS path:</strong> <?php echo htmlspecialchars($_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/'); ?>assets/css/modern-theme.css</p>
    </div>

    <div class="test-box">
        <h3>CSS Test Elements:</h3>
        <div class="sidebar" style="display: inline-block; padding: 20px; margin: 10px;">
            This should have blue gradient background if CSS loaded
        </div>
        <button class="btn btn-primary">This button should be styled</button>
    </div>

    <div class="test-box">
        <h3>File Check:</h3>
        <?php
            $cssPath = __DIR__ . '/assets/css/modern-theme.css';
            if (file_exists($cssPath)) {
                echo "<p style='color: green;'>✓ CSS file exists at: $cssPath</p>";
                echo "<p>File size: " . filesize($cssPath) . " bytes</p>";
            } else {
                echo "<p style='color: red;'>✗ CSS file NOT found at: $cssPath</p>";
            }
        ?>
    </div>

    <script>
        // Check if CSS loaded
        window.addEventListener('load', function() {
            const links = document.querySelectorAll('link[rel="stylesheet"]');
            links.forEach(link => {
                console.log('CSS Link:', link.href);
            });
        });
    </script>
</body>
</html>
