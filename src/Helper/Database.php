<?php
namespace Meradoou\Skeleton\Helper;

use \Psr\Http\Message\ServerRequestInterface;
use \Psr\Http\Message\ResponseInterface;

/**
 * Gérer la connexion à la base de donnée
 *
 * @author mirado <me.radoou@gmail.com>
 */
class Database
{
    /**
     * Initier la discussion avec la base de donnée
     *
     * @param  ServerRequestInterface $request  PSR7 request
     * @param ResponseInterface      $response PSR7 response
     * @param Callable $next     Next middleware
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $next)
    {
        \ORM::configure('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME);
        \ORM::configure('username', DB_USER);
        \ORM::configure('password', DB_PWD);
        \ORM::configure('driver_options', [
            \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
        ]);

        \ORM::configure('logging', true);

        return $next($request, $response);
    }
}
