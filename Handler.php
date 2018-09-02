
<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 21/8/18
 * Time: 11:52 AM
 */
ini_set('display_errors', 1);

/*function parseHook() {
    if (isset($_GET['_h'])) {
        $hook = explode('/', filter_var(rtrim($_GET['_h'], '/'), FILTER_SANITIZE_URL));
        echo "<pre>";
        print_r($hook);
        echo "</pre>";
        exit;
    } else {
        return false;
    }
}

$hook = parseHook();
//Register Hooks
$hooks = ['lang','score'];

if ($hook && in_array($hook[0],$hooks) && function_exists($hook[0])) {
    $callMe = $hook[0];
    unset($hook[0]);
    $params = $hook ? array_values($hook) : [];
    $callMe($params);
}

function lang($params) {
    echo "<pre>";
    print_r($params);
    echo "</pre>";
    exit;
}

function score($params) {
    echo "score";
}*/

class RequestHandler
{

	protected $classObject;
	protected $currentUrl;
	//Find extenstion in url
	protected $searchWord = ".php";

	public function __construct($obj)
	{

		$this->classObject = $obj;
		$this->currentUrl = explode('/', trim($_SERVER['REQUEST_URI'], '/'), FILTER_SANITIZE_URL);
		self::init();
	}

	/**
	 * initialize the function
	 * @author : Akshay Mahajan
	 * @return : void
	 *
	 */
	public function init()
	{
		$this->processRequestUrl();
	}

	/**
	 * Processing for user request
	 *
	 * @show If something interesting cannot happen
	 * @author : Akshay Mahajan
	 * @return : void
	 *
	 */
	private function processRequestUrl()
	{

		$searchword = $this->searchWord;
		// Find php file extenstion in url
		$matches = array_filter($this->currentUrl, function ($var) use ($searchword) {
			return preg_match("/\b$searchword\b/i", $var);
		});
		if (!empty($matches)) {
			// Slice the url from matched key
			$sliceUrl = array_slice($this->currentUrl, key($matches));
			array_shift($sliceUrl);
			//Check function paramter present after matching key
			if (!empty($sliceUrl)) {
				//Check function present in class file
				if (method_exists($this->classObject, $sliceUrl[0])) {
					$callMethod = array_shift($sliceUrl);
					call_user_func_array(array($this->classObject, $callMethod), $sliceUrl);
				} else {
					die("Error : Sorry method not found.");
				}
			} else {
				$this->classObject->index();
			}

		} else {
			die("Error : PHP file not found.");
		}
	}
}