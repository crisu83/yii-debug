<?php
/**
 * Debugger class file.
 * @author Christoffer Niska <christoffer.niska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2013-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

/**
 * Helper for enabling debugging based on the ip address.
 */
class Debugger
{
    /**
     * Initializes the debugger.
     */
    public static function init($debugFile)
    {
        $debug = false;
        if (file_exists($debugFile))
        {
            $ipFilter = file_get_contents($debugFile);
            if (empty($ipFilter) || (isset($_SERVER['REMOTE_ADDR']) && self::allowIp($ipFilter, $_SERVER['REMOTE_ADDR'])))
            {
                // Set some php variables.
                error_reporting(E_ALL);
                ini_set('display_errors', 1);

                // Enable yii debugging and set the trace level to 3.
                defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);
                $debug = true;
            }
        }
        defined('YII_DEBUG') or define('YII_DEBUG', $debug);
    }

    /**
     * Returns whether the given address is listed in the given ip filter.
     * @param string $ipFilters the ip filter to check against.
     * @param string $ip the ip address.
     * @return boolean the result.
     */
    public static function allowIp($ipFilter, $ip)
    {
        return $ipFilter === '*' || $ipFilter === $ip || (($pos = strpos($ipFilter, '*')) !== false && !strncmp($ip, $ipFilter, $pos));
    }
}
