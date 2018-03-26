<?php
namespace Meradoou\Skeleton\Helper;

use \Slim\Http\Request;
use \Slim\Http\Response;
use \Slim\Container;

/**
 * Gérer les vues
 *
 * @author mirado <me.radoou@gmail.com>
 */
class View
{
    protected $app;

    protected $parameters = [];

    /**
     * Construire l'objet en passant une instance de Pimple
     *
     * @param Container $pimple
     */
    public function __construct(Container $container)
    {
        $this->initialize($container);
    }

    /**
     * Initialiser les vues
     *
     * @param string $template
     * @param array $variables
     * @param integer $status
     * @return void
     */
    public function initialize($container)
    {
        $this->app = $container;
        $this->setParameter('uri', $container->request->getUri());
    }
    
    /**
     * Envoyer une réponse HTML
     *
     * @param string $template
     * @param array $variables
     * @param integer $status
     * @return void
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
        
        return $this->app->response->withStatus($status)->getBody()->write($content);
    }


    /**
     * Envoyer une réponse JSON
     *
     * @param string $template
     * @param array $variables
     * @return string
     */
    public function json($variables = [], $status = 200)
    {
        return $this->app->response->withJson($variables)->withStatus($status);
    }
    
    /**
     * Formatter un URI en URI correct par rapport à la racine
     *
     * @param string $path
     * @return string
     */
    public function url($path = null)
    {
        if ($path) {
            return $this->app->request->getUri()->getBasePath() . $path;
        }
        
        return $this->app->request->getUri()->getBasePath();
    }
    
    /**
     * Formatter les URL des assets
     *
     * @param string $path
     * @return string
     */
    public function asset($filename)
    {
        $url = $this->url();
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

    /**
     * Definir une information à partager dans les vues
     *
     * @param string $name
     * @param string $value
     * @return View
     */
    public function setParameter($name, $value = null)
    {
        if (!isset($this->parameters[$name])) {
            $this->parameters[$name] = $value;
        }

        return $this;
    }
}
