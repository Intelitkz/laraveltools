<?php namespace Intelitkz\Laraveltools;

use Doctrine\Common\Collections\Collection;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;


class PagesManager
{
	private static $instance;

	/**
	 * @var Page[]|\Illuminate\Support\Collection
	 */
	private $pages = [];

	public static function instance()
	{
		if(!self::$instance)
			self::$instance = new static;

		return self::$instance;
	}

	/**
	 * @return \Illuminate\Support\Collection
	 */
	public function get()
	{
		return $this->pages;
	}

	/**
	 * PagesManager constructor.
	 * @param array $pages
	 */
	public function __construct()
	{
		$this->pages = collect(\Config::get('pages'));
	}

	public function setRoutes()
	{
		foreach ($this->pages as $page)
		{
			if(!$page->uses)
				continue;

			switch($page->method)
			{
				case 'get':
					\Route::get($page->getUri(false), ['as' => $page->name, 'uses' => $page->uses]);
					break;
				case 'post':
					\Route::post($page->getUri(false), ['as' => $page->name, 'uses' => $page->uses]);
					break;
				case 'patch':
					\Route::patch($page->getUri(false), ['as' => $page->name, 'uses' => $page->uses]);
					break;
				case 'delete':
					\Route::patch($page->getUri(false), ['as' => $page->name, 'uses' => $page->uses]);
					break;
				case 'any':
					\Route::any($page->getUri(false), ['as' => $page->name, 'uses' => $page->uses]);
			}
		}

	}

	/**
	 * @return \Illuminate\Support\Collection
	 */
	public function getParentForBreadcrumbs(Page $page)
	{
		return $this->pages->where('name', $page->parentForBreadcrumbs)->first();
	}

	/**
	 * @return \Illuminate\Support\Collection
	 */
	public function getChildren($page, $forMenu = false)
	{
		$parentProperty = $forMenu ? 'parent': 'parentForBreadcrumbs';

		return $this->pages->where($parentProperty, $page->name);
	}

	public function setBreadcrumbs()
	{
		foreach ($this->pages as $page)
		{
			\Breadcrumbs::register($page->name, function($breadcrumbs) use ($page)
			{
				$parent = $this->getParentForBreadcrumbs($page);

				$uri = '/'.ltrim($page->custom_uri ?: $page->name, '/');

				($parent)
					? $breadcrumbs->parent($parent->name)
					: ($page->name != 'home' && $breadcrumbs->parent('home'));

				$breadcrumbs->push($page->getTitle(), $uri, ['hasController' => (bool) $page->uses]);
			});
		}
	}
}
