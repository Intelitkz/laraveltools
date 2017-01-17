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
	public $uses;
	public $parent;
	public $parentForBreadcrumbs;
	public $parentForMenu;
	public $method; // get 25
	public $in_menu; // true 30
	public $custom_uri; // '' 34
	public $sorting = 50;
	public $restrictedRoles = [];
	public $bannedRoles = [];
	public $allowedRoles = [];

	/**
	 * Page constructor.
	 * @param $name
	 * @param $uses
	 * @param $parent
	 * @param $method
	 * @param $in_menu
	 * @param $custom_uri
	 */
	public function __construct($name, $uses, $parent, $method = 'get', $in_menu = TRUE, $custom_uri = '')
	{
		$this->name                 = $name;
		$this->uses                 = $uses;
		$this->parent               = $parent;
		$this->parentForBreadcrumbs = $parent;
		$this->parentForMenu        = $parent;
		$this->method               = $method;
		$this->in_menu              = $in_menu;
		$this->custom_uri           = $custom_uri;
	}

	public static function __set_state($params)
	{
		$instance = new static(
			$params['name'],
			$params['uses'],
			$params['parent'],
			$params['method'],
			$params['in_menu'],
			$params['custom_uri']
		);

		$instance->sorting              = $params['sorting'];
		$instance->restrictedRoles      = $params['restrictedRoles'];
		$instance->bannedRoles          = $params['bannedRoles'];
		$instance->allowedRoles         = $params['allowedRoles'];
		$instance->parentForBreadcrumbs = $params['parentForBreadcrumbs'];

		return $instance;
	}

	/**
	 * @param mixed $parentForBreadcrumbs
	 */
	public function setParentForBreadcrumbs($parentForBreadcrumbs)
	{
		$this->parentForBreadcrumbs = $parentForBreadcrumbs;

		return $this;
	}

	/**
	 * @param mixed $parentForMenu
	 */
	public function setParentForMenu($parentForMenu)
	{
		$this->parentForMenu = $parentForMenu;
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
	 * @param int $sorting
	 */
	public function setSorting($sorting)
	{
		$this->sorting = $sorting;

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
}