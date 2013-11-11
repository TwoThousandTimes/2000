<?php
/**
 * This is basically a wrapper around the Flickr API
 * 	The license is currently set to no attribution, but we'll figure that out soon.
 */

class FlickrRestController extends \BaseController {

	/**
	 * API Keys and stuff
	 */
	private static $api_key = "4007f7ba7ba7140bdbe7019d92f8d204";
	private static $secret = "2d10c3bd19990c67";
	private static $url = "http://api.flickr.com/services/rest/?";

	/**
	 * Display a listing of pictures based on a tag based search.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		$params = array(
			'api_key' => self::$api_key,
			'method' => 'flickr.photos.search',
			'format'	=> 'php_serial',
			'text' => Input::get( 'text' ),//This one we'll have to think about a bit, but it shouldn't be too hard.
			'safe_search' => '2',
			'license' => '7'//This one can be CSVed
		);
		
		$encoded_params = array();
		
		foreach ($params as $k => $v){
			$encoded_params[] = urlencode($k).'='.urlencode($v);
		}
		
		$response = file_get_contents(self::$url.implode('&', $encoded_params));
		
		if(count($response)) {
			return Response::json(
				unserialize($response),//kind of stupid that we're doing this json response thing by decoding and encoding again...
				200//response is OK!
			);
		} else {
			return Response::json(
				'Error',
				404//response is NOT OK!
			);
		}
	}

	/**
	 * Display the specified image from Flickr
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
		$params = array(
			'api_key'	=> self::$api_key,
			'method'	=> 'flickr.photos.getSizes',
			'photo_id'	=> $id,
			'format'	=> 'php_serial',
		);
		
		$encoded_params = array();
		
		foreach ($params as $k => $v){
			$encoded_params[] = urlencode($k).'='.urlencode($v);
		}
		
		$response = file_get_contents(self::$url.implode('&', $encoded_params));
		
		if(count($response)) {
			return Response::json(
				unserialize($response),
				200//response is OK!
			);
		} else {
			return Response::json(
				'Error',
				404//response is NOT OK!
			);
		}
	}

}