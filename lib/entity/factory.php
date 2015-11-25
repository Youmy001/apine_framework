<?php
/**
 * Basic Factory declaration.
 * 
 * @license MIT
 * @copyright 2015 Tommy Teasdale
 */

/**
 * This is the implementation of the factory
 * design patern.
 */
abstract class ApineEntityFactory {

	/**
	 * Procedure to fetch every rows in a factory's scope
	 * 
	 * @abstract @static
	 *
	 */
	abstract public static function create_all();
	
	/**
	 * Procedure to fetch a row in a factory's scope matching provided
	 * identifier
	 * 
	 * @param string $a_id
	 *        Identifier of the row to fetch
	 * @abstract @static
	 *
	*/
	abstract public static function create_by_id($a_id);

}