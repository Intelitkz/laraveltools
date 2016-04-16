<?php namespace Intelitkz\Laraveltools;

use Doctrine\Common\Collections\Collection;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;


class Pages
{
	private static $instance;
	private $pages = [];

	public static function instance()
	{
		if(!self::$instance)
			self::$instance = new self;

		return self::$instance;
	}

	/**
	 * @return \Illuminate\Support\Collection
	 */
	public function getPages()
	{
		return $this->pages;
	}

	/**
	 * Pages constructor.
	 * @param array $pages
	 */
	public function __construct()
	{
//		dd(collect(\Config::get('pages'))->where('in_menu', true)->where());
		$this->pages = collect(\Config::get('pages'));
	}

	public function getUri($page)
	{
		if ($uri = data_get($page, 'custom_uri'))
			return $uri;

		$uri = $page['uri_prefix'].$page['name'].$page['uri_suffix'];

		return $uri;
	}

	public function getName($page)
	{
		return $page['method'].ucfirst($page['name']);
	}

	public function getTitle($page)
	{
		return trans('pages.'.$page['name']);
	}

	public function setRoutes()
	{
		$pages = collect(\Config::get('pages'));

		foreach ($pages as $page)
		{
			if(!$page['uses'])
				continue;

			switch($page['method'])
			{
				case 'get':
					\Route::get($this->getUri($page), ['as' => $this->getName($page), 'uses' => $page['uses']]);
					break;
				case 'post':
					\Route::post($this->getUri($page), ['as' => $this->getName($page), 'uses' => $page['uses']]);
					break;
				case 'patch':
					\Route::patch($this->getUri($page), ['as' => $this->getName($page), 'uses' => $page['uses']]);
					break;
				case 'delete':
					\Route::patch($this->getUri($page), ['as' => $this->getName($page), 'uses' => $page['uses']]);
					break;
				case 'any':
					\Route::any($this->getUri($page), ['as' => $this->getName($page), 'uses' => $page['uses']]);
			}
		}

	}

	/**
	 * @return \Illuminate\Support\Collection
	 */
	public function getParent($page)
	{
		return $this->pages->where('id', $page['parent_id'])->first();
	}

	/**
	 * @return \Illuminate\Support\Collection
	 */
	public function getChildren($page)
	{
		return $this->pages->where('parent_id', $page['id']);
	}

	public function setBreadcrumbs()
	{
		foreach ($this->pages as $page)
		{
			\Breadcrumbs::register($this->getName($page), function($breadcrumbs) use ($page)
			{
				$parent = $this->getParent($page);
				$hasController = function() use ($page){
					return (bool) data_get($page, 'uses');
				};

				($parent)
					? $breadcrumbs->parent($this->getName($parent))
					: ($this->getName($page) != 'getHome' && $breadcrumbs->parent('getHome'));

				$breadcrumbs->push($this->getTitle($page), $this->getUri($page), ['hasController' => $hasController()]);
			});
		}
	}
}
