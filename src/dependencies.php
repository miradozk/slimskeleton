<?php
use \Meradoou\Skeleton\Helper\Database;
use \Meradoou\Skeleton\Helper\View;

/**
 * Middleware
 *
 */

// Database
$application->add(new Database());

/**
 * Services
 *
 */
$services = $application->getContainer();

// View
$services['view']  = function ($container) {
    return new View($container);
};
