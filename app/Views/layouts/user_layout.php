<?php
// User layout wrapper - uses unified main layout
// This file maintained for backward compatibility with existing views

// Force user role for this layout
$isAdmin = false;

// Include unified layout (it will output $content variable)
require_once __DIR__ . '/main_layout.php';
