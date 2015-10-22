<?php
/**
 * Custom Exception Handler
 * This script contains a custom exception handler
 *
 * @license MIT
 * @copyright 2015 Tommy Teasdale
 */

/**
 * Custom implementation of the exception handler matching
 * more closely a RESTful approach
 * 
 * @author Tommy Teasdale
 */
class ApineException extends Exception {

	protected $code = 500;

	public function __construct($message = null, $code = 500, Exception $previous = null){

		parent::__construct($message, $code, $previous);

	}

}

class ApineHttpException extends Exception {
	
	public function __construct($code, Exception $previous = null) {
		
		parent::__construct('', $code, $previous);
		
	}
	
}

/**
 * Custom implementation of the PDO exception handler
 * 
 * @author Tommy Teasdale
 */
class DatabaseException extends PDOException {
}