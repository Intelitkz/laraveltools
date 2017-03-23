<?php namespace Intelitkz\Laraveltools;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;


class PagesManager {
	private static $instance;

	/**
	 * @var Page[]|\Illuminate\Support\Collection
	 */
	private $pages = [];

	public static function instance()
	{
		if (!self::$instance)
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

	protected function flatten(Collection $source, Collection $target = null)
	{
		$flatpages = $target ?: collect();

		$source->each(function ($page) use (&$flatpages)
		{
			$flatpages->push($page);

			if($page->children->count())
				$this->flatten($page->children, $flatpages);
		});

		return $flatpages;
	}

	protected function flatpages()
	{
		return $this->flatten($this->pages);
	}

	public function setRoutes()
	{
		foreach ($this->flatpages() as $page)
		{
			if (!$page->uses)
				continue;

			switch ($page->method)
			{
				case 'get':
				default:
					\Route::get($page->getUri(FALSE), ['as' => $page->name, 'uses' => $page->uses]);
					break;
				case 'post':
					\Route::post($page->getUri(FALSE), ['as' => $page->name, 'uses' => $page->uses]);
					break;
				case 'patch':
					\Route::patch($page->getUri(FALSE), ['as' => $page->name, 'uses' => $page->uses]);
					break;
				case 'delete':
					\Route::patch($page->getUri(FALSE), ['as' => $page->name, 'uses' => $page->uses]);
					break;
				case 'any':
					\Route::any($page->getUri(FALSE), ['as' => $page->name, 'uses' => $page->uses]);
			}
		}

	}

	public function setBreadcrumbs()
	{
		foreach ($this->pages as $page)
		{
			\Breadcrumbs::register($page->name, function ($breadcrumbs) use ($page)
			{
				$uri = '/'.ltrim($page->custom_uri ?: $page->name, '/');

				($page->parent)
					? $breadcrumbs->parent($page->parent->name)
					: ($page->name != 'home' && $breadcrumbs->parent('home'));

				$breadcrumbs->push($page->getTitle(), $uri, ['hasController' => (bool) $page->uses]);
			});
		}
	}
}
