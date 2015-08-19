<?php
/**
 * User Factory declaration.
 *
 * This file contains the user factory class.
 * @author Tommy Teasdale <tteasdaleroads@gmail.com>
 * @package apine-framework
 * @subpackage system
 */

class ApineUserFactory extends ApineFactory {

	/**
	 * Verify if the identifier exists
	 * @param integer $user_id        
	 * @return boolean
	 */
	public static function is_id_exist($user_id) {

		//$id_sql = (new Database())
		$database=new Database();
		$id_sql = $request->select("SELECT `id` FROM `apine_users` WHERE `id`=$user_id");
		
		if ($id_sql) {
			return true;
		}
		
		return false;
	
	}

	/**
	 * Verify if a user uses the provided name
	 * @param string $user_name
	 *        User username
	 * @return boolean
	 */
	public static function is_name_exist($user_name){

		//$id_sql = (new Database())
		$database=new Database();
		$id_sql = $request->select("SELECT `id` FROM `apine_users` WHERE `username`='$user_name'");
		
		if ($id_sql) {
			return true;
		}
		
		return false;
	
	}

	/**
	 * Verify if a user uses the provided email address
	 * @param string $user_mail
	 *        User email address
	 * @return boolean
	 */
	public static function is_email_exist($user_mail) {

		//$id_sql = (new Database())
		$database=new Database();
		$id_sql = $request->select("SELECT `id` FROM `apine_users` WHERE `email`='$user_mail'");
		
		if ($id_sql) {
			return true;
		}
		
		return false;
	
	}
	/**
	 *
	 * @return Liste
	 */
	public static function create_all() {

		//$request = (new Database())
		$database=new Database();
		$request = $request->select('SELECT `id` from `apine_users` ORDER BY `username`');
		$liste = new Liste();
		
		if ($request != null && count($request) > 0) {
			foreach ($request as $item) {
				$liste->add_item(new ApineUser($item['id']));
			}
		}
		
		return $liste;
	
	}

	/**
	 *
	 * @param integer $a_id
	 *        User Identifier
	 * @return User
	 */
	public static function create_by_id($a_id) {
		
		$database=new Database();
		$user_sql_id = $database->prepare('SELECT `id` FROM `apine_users` WHERE `id`=?');
		$ar_user_sql = $database->execute(array(
						$a_id
		), $user_sql_id);
		
		if ($ar_user_sql) {
			$return = new ApineUser($ar_user_sql[0]['id']);
		} else {
			$return = null;
		}
		
		return $return;
	
	}

	/**
	 * Fetch a user by username
	 * @param string $name
	 *        User username
	 * @return User
	 */
	public static function create_by_name($name) {

		$database = new Database();
		$user_sql_id = $database->prepare('SELECT `id` FROM `apine_users` WHERE `username`=?');
		$ar_user_sql = $database->execute(array(
						$name
		), $user_sql_id);
		
		if ($ar_user_sql) {
			$user_id = end($ar_user_sql);
			$user_id = $user_id['id'];
			$lang = new ApineUser($user_id);
		} else {
			$lang = null;
		}
		
		return $lang;
	
	}

	/**
	 * Fetch apine_users by permission level
	 * @param integer $access
	 *        User Permission level
	 * @return Liste
	 */
	public static function create_by_access_right($access) {

		//$request = (new Database())
		$database=new Database();
		$request = $request->select("SELECT `id` FROM `apine_users` WHERE `type`=$access");
		$liste = new Liste();
		
		if ($request != null && count($request) > 0) {
			foreach ($request as $item) {
				$liste->add_item(new ApineUser($item['id']));
			}
		}
		
		return $liste;
	
	}
	
	/**
	 * Fetch apine_users by group
	 * @param integer $access
	 *        User Group
	 * @return Liste
	 */
	public static function create_by_group($group) {
	
		//$request = (new Database())
		$database=new Database();
		$request = $request->select("SELECT `user_id` FROM `apine_users_user_group` WHERE `group_id`=$group");
		$liste = new Liste();
		
		if ($request != null && count($request) > 0) {
			foreach ($request as $item) {
				$liste->add_item(new ApineUser($item['user_id']));
			}
		}
		
		return $liste;
	
	}
	
	/**
	 * Authentifiate a user with a combination of a user name and an
	 * encoded password.
	 *
	 * @param string $name
	 *        Username
	 * @param string $pass
	 *        Encrypted password
	 * @return integer
	 */
	public static function authentication($name, $pass) {
		
		$database=new Database();
		$connect_sql_id = $database->prepare('SELECT `id` FROM `apine_users` WHERE `username`=? OR `email`=? AND `password`=?');
		$ar_connect_sql = $database->execute(array(
						$name,
						$name,
						$pass
		), $connect_sql_id);
		
		if ($ar_connect_sql) {
			$connect = end($ar_connect_sql);
			$connect = $connect['id'];
		} else {
			$connect = 0; // Value of false
		}
		
		return $connect;
	
	}

}