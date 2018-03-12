<?php
use \Meradoou\Skeleton\Helper\Database;

/**
 * Middleware
 *
 */

// Session
$application->add(new Database());

/**
 * Services
 *
 */
$services = $application->getContainer();
