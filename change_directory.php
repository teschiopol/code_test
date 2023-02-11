<?php

/**
  * Path
  * 
  * 
  * @author Paolo Concolato
*/
class Path {
 	
	private $root;
	private $separator;
	private $basePath;
	public $currentPath;
	

	function __construct($basePath = '/') {
 		$this->root = '/';
 		$this->separator = '/';
 		$this->basePath = $basePath;
 		$this->currentPath = '';
	}

	
  /**
    * 
    * Parse with the standard
    *
    * @param string $changePath path of cd operator     
    * @return void
  */
	private function parse_path($changePath){

		// Only English alphabet
		$regex = '/^[a-zA-Z]+$/i';

		// Base case
		if(in_array($changePath, array('/', '..')) || preg_match($regex, $changePath)){
			return;
		}

		// Split with the separator
		$dir = explode($this->separator, $changePath);

		// Every single word or empty
		if(count($dir) < 2){
			die('Path not valid');
		}

		foreach ($dir as $value) {
			if(!in_array($value, array('/', '..', '')) && !preg_match($regex, $value)){
				die('Path not valid');
			}
		}
	}


	/**
    * 
    * Cd operation
    *
    * @param string $path path of cd operator     
    * @return void
  */
	function cd($path){
		$path = trim($path);

		// Parsing
		self::parse_path($path);

		if($path === '/'){
			$this->currentPath = $path;
			return;
		}

		if(strpos($path, '..') === false && strpos($path, '/') === false){
			$this->currentPath = $this->basePath.'/'.$path;
			return;
		}

		// Define levels
		$levels = explode($this->separator, $this->basePath);

		// Only '..'
		$newPath = '';
		$dir = explode($this->separator, $path);

		foreach($dir as $value){
			if($value === '..'){
				// Level up
				array_pop($levels);
			}elseif($value === ''){
				// Finish
				break;
			}else{
				// Directory
				$levels[] = $value;
			}
		}

		// Return
		$newPath = implode('/', $levels);
		$this->currentPath = $newPath;
	}
}

// Main to run
$path = new Path('/a/b/c/d');

$test = array(
	'../x',
 	'../',
 	'/gee',
  '..',
  '/',
  'r', 
  'h ',
  'shwb55FF', 
  '../ rwU',
  '',
  4
);

$path->cd($test[6]);
echo $path->currentPath;

?>
