<?php
namespace Meradoou\Skeleton\Helper;

/**
 * Envoyer de requete HTTP avec Curl
 *
 * @author mirado<me.radoou@gmail.com>
 */
class Http
{
    /**
     * Wrapper pour CURL afin de faciliter l'envoi de requete
     * et l'utilisation de API via HTTP
     *
     * @param string $baseUrl URL qui va recevoir la requete
     * @param array  $options Options additionnelles à CURL
     * @return string response from a server
     */
    public static function http($baseUrl, $options = array())
    {
        $resource = curl_init($baseUrl);
        
        $args = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_COOKIESESSION => true
        );
        
        if (!empty($options) && is_array($options)) {
            foreach ($options as $k => $v) {
                $args[$k] = $v;
            }
        }
        curl_setopt_array($resource, $args);
        
        $response = [
          'body' => curl_exec($resource)
        ];
          
        $response = array_merge(curl_getinfo($resource), $response);
        
        if (curl_errno($resource)) {
            throw new \Exception(curl_error($resource));
        }
        
        curl_close($resource);
        
        return $response;
    }

    /**
     * Envoyer une requete POST
     *
     * @param string $baseUrl
     * @param array $data
     * @param array $headers
     * @param array $options
     * @return mixed
     */
    public static function post($baseUrl, $data = array(), $headers = array(), $options = array())
    {
        $args = array(
            CURLOPT_POSTFIELDS => http_build_query($data),
            CURLOPT_POST => true
        );
    
        if (!empty($options)) {
            foreach ($options as $key => $value) {
                $args[$key] = $value;
            }
        }
        if (!empty($headers)) {
            $args[CURLOPT_HTTPHEADER] = $headers;
        }
     
        $response = self::http($baseUrl, $args);
        
        return $response;
    }

    /**
     * Envoyer une requete GET
     *
     * @param string $baseUrl
     * @param array $data
     * @param array $headers
     * @param array $options authentification avec CURLOPT_USERPWD = 'user:pass' et CURLOPT_HTTPAUTH = CURLAUTH_BASIC
     * @return mixed
     */
    public static function get($baseUrl, $data = array(), $headers = array(), $options = array())
    {
        $args = array(
            CURLOPT_POST => false
        );
    
        if (!empty($options)) {
            foreach ($options as $key => $value) {
                $args[$key] = $value;
            }
        }
        if (!empty($headers)) {
            $args[CURLOPT_HTTPHEADER] = $headers;
        }
        if (!empty($data)) {
            $baseUrl = sprintf('%s?%s', $baseUrl, http_build_query($data));
        }
        $response = self::http($baseUrl, $args);
        
        return $response;
    }

    /**
     * Envoyer une requete PATCH
     *
     * @param string $baseUrl
     * @param array $data
     * @param array $headers
     * @param array $options
     * @return mixed
     */
    public static function patch($baseUrl, $data = array(), $headers = array(), $options = array())
    {
        $args = array(
            CURLOPT_POSTFIELDS => http_build_query($data),
            CURLOPT_CUSTOMREQUEST => 'PATCH'
            // CURLOPT_POST => true
        );
    
        if (!empty($options)) {
            foreach ($options as $key => $value) {
                $args[$key] = $value;
            }
        }
        if (!empty($headers)) {
            $args[CURLOPT_HTTPHEADER] = $headers;
        }
     
        $response = self::http($baseUrl, $args);
        
        return $response;
    }
}
