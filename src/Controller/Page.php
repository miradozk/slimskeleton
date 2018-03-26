<?php
namespace Meradoou\Skeleton\Controller;

use \Slim\Http\Request;
use \Slim\Http\Response;
use \Meradoou\Skeleton\Helper\Http;

/**
 * Les différentes pages statiques
 *
 * @author mirado<me.radoou@gmail.com>
 */
class Page extends Controller
{
    /**
     * Controleur pour la homepage
     *
     * @param Request $request
     * @param Response $response
     * @return string
     */
    public function showHome(Request $request, Response $response)
    {
        return $this->view->html('home.php');
    }
}
