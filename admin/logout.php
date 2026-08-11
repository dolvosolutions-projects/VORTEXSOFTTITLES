<?php
/**
 * Admin — logout
 */
require_once dirname(__DIR__) . '/config/app.php';
require_once dirname(__DIR__) . '/includes/functions.php';
session_destroy();
redirect('/admin/login.php');
