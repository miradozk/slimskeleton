<?php
namespace Meradoou\Skeleton\Controller;

use \Pimple\Container;

/**
 *
 * @author mirado <me.radoou@gmail.com>
 */
abstract class Controller
{
    protected $container;
    
    /**
     * Construire le controleur pour rendre le container disponible sur chaque methode
     * et définir les variables par defaut accessible pour les vues
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }
}
