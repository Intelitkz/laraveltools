<?php
/**
 * Created by PhpStorm.
 * User: Nurbol
 * Date: 23.07.2016
 * Time: 1:59
 */

namespace Intelitkz\Laraveltools;


use App\Helpers\Utils;

class Page {

	public $name;
	public $uri;
	public $uses;
	public $parent;
	public $method;
	public $in_menu;
	public $custom_uri;
	public $index = 50;
	public $restrictedRoles = [];
	public $bannedRoles = [];
	public $allowedRoles = [];
	public $children;
	public $routeSet = FALSE;

	/**
	 * Page constructor.
	 * @param $name
	 * @param $uses
	 * @param $method
	 * @param $in_menu
	 * @param $custom_uri
	 */
	public function __construct($name, $uses = NULL, $method = 'get', $in_menu = TRUE, $custom_uri = '')
	{
		$this->name       = $name;
		$this->uri        = $custom_uri ?: $name;
		$this->uses       = $uses;
		$this->method     = $method;
		$this->in_menu    = $in_menu;
		$this->custom_uri = $custom_uri;
		$this->children   = collect();
	}

	public static function new($name, $uses = NULL, $method = 'get', $in_menu = TRUE, $custom_uri = '')
	{
		return new static($name, $uses, $method, $in_menu, $custom_uri);
	}

	public static function __set_state($params)
	{
		$instance = new static(
			$params['name'],
			$params['uses'],
			$params['method'],
			$params['in_menu'],
			$params['custom_uri']
		);

		$instance->index           = $params['index'];
		$instance->restrictedRoles = $params['restrictedRoles'];
		$instance->bannedRoles     = $params['bannedRoles'];
		$instance->allowedRoles    = $params['allowedRoles'];

		return $instance;
	}

	public function getTitle($forMenu = FALSE)
	{
		if (!$forMenu)
		{
			if (\Route::current()->getName() == $this->name)
				return Utils::pageTitle('');

			if ((array_key_exists('modify', \Request::all()) || array_key_exists('update', \Request::all()))
			    && \Request::route()->getUri() == $this->getUri(FALSE)
			)
				$title = trans('pages.'.$this->name.'.modify');
		}

		if (empty($title))
			$title = trans('pages.'.$this->name);

		if (is_array($title))
			$title = $forMenu ? '<i class="glyphicon glyphicon-'.$title[0].'"></i> '.$title[1] : $title[1];

		return $title;
	}

	public function getUri($relative = TRUE)
	{
		$uri = $this->custom_uri ?: $this->name;

		return $relative ? '/'.$uri : $uri;
	}

	/**
	 * @param int $index
	 */
	public function index($index)
	{
		$this->index = $index;

		return $this;
	}

	public function restrict($role)
	{
		$this->restrictedRoles = func_get_args();

		return $this;
	}

	public function ban($role)
	{
		$this->bannedRoles = func_get_args();

		return $this;
	}

	public function allow($role)
	{
		$this->allowedRoles = func_get_args();

		return $this;
	}

	public function children(array $children)
	{
		foreach ($children as $key => $child)
		{
			$children[$key]->parent = $this; // todo cancel
		}

		$this->children = collect($children)->sortBy('index');

		return $this;
	}
}