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

    protected $parameters;
    
    /**
     * Construire le controleur pour rendre le container disponible sur chaque methode
     * et définir les variables par defaut accessible pour les vues
     *
     * @param Container $container [description]
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        
        $this->parameters = [
            'uri' => $this->container->request->getUri()
        ];
    }
    

    /**
     * Envoyer une réponse en HTML après traitement des données
     *
     * @param string $template
     * @param array $variables
     * @return string
     */
    public function html($template, $variables = [], $status = 200)
    {
        $this->parameters = array_merge($variables, $this->parameters);
        
        $template =  __DIR__ . '/../views/' . $template;
        
        if (!file_exists($template)) {
            throw new \Exception('Template introuvable!');
        }
        
        
        ob_start();

        extract($this->parameters);
        
        require $template;
        
        $content = ob_get_clean();
        
        return $this->container->response->withStatus($status)->getBody()->write($content);
    }
    
    /**
     * Envoyer une réponse en JSON
     *
     * @param string $template
     * @param array $variables
     * @return string
     */
    public function json($variables = [], $status = 200)
    {
        return $this->container->response->withJson($variables)->withStatus($status);
    }
    
    /**
     * Créer un URL correct par rapport à la base path de l'application
     *
     * @param string $path
     * @return string
     */
    public function url($path = null)
    {
        if ($path) {
            return $this->container->request->getUri()->getBasePath() . $path;
        }
        return $this->container->request->getUri()->getBasePath();
    }
    
    /**
     * Traiter les URL des assets
     *
     * @param string $path
     * @return string
     */
    public function asset($filename)
    {
        $url = '';
        $path = pathinfo($filename);
        
        if (isset($path['extension'])) {
            $filename = trim($filename, '/');
        
            switch ($path['extension']) {
                case 'css':
                    $url = $this->url(URI_CSS . $filename);
                    break;
                    
                case 'js':
                    $url = $this->url(URI_JS . $filename);
                    break;
                    
                default:
                    $url = $this->url(URI_IMAGE . $filename);
                    break;
            }
        }
        
        if (defined('CACHE_ASSETS') && CACHE_ASSETS === false) {
            $url = $url . '?version=' . time();
        }
        
        return $url;
    }
}
