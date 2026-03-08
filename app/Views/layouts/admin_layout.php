<?php
// Admin layout wrapper - uses unified main_layout
// This file maintained for backward compatibility with existing views

// Force admin role for this layout  
$isAdmin = true;

// Include unified layout (it will output $content variable)
require_once __DIR__ . '/main_layout.php';
?>
