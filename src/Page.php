<?php namespace Intelitkz\Laraveltools;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

/**
 * App\Models\Page
 *
 * @property integer $id
 * @property string $method
 * @property string $name
 * @property string $uses
 * @property string $uri_prefix
 * @property string $uri_suffix
 * @property string $parent
 * @property boolean $in_menu
 * @property \Carbon\Carbon $deleted_at
 */
class Page extends \Eloquent
{
	use SoftDeletes;

	/**
	 * The attributes that should be mutated to dates.
	 *
	 * @var array
	 */
	protected $dates = ['deleted_at'];

	public function getUri()
	{
		if ($this->custom_uri)
			return $this->custom_uri;

		$uri = $this->name;
		$uri = $this->uri_prefix.$uri.$this->uri_suffix;

		return $uri;
	}

	public function getName()
	{
		return $this->method.ucfirst($this->name);
	}

	public function getTitle()
	{
		return trans('pages.'.$this->name);
	}

	public static function  setRoutes()
	{
		if (!\Schema::hasTable('pages'))
			return false;

		foreach (self::all() as $page)
		{
			switch($page->method)
			{
				case 'get':
					\Route::get($page->getUri(), ['as' => $page->getName(), 'uses' => $page->uses]);
					break;
				case 'post':
					\Route::post($page->getUri(), ['as' => $page->getName(), 'uses' => $page->uses]);
					break;
				case 'patch':
					\Route::patch($page->getUri(), ['as' => $page->getName(), 'uses' => $page->uses]);
					break;
				case 'delete':
					\Route::patch($page->getUri(), ['as' => $page->getName(), 'uses' => $page->uses]);
					break;
				case 'any':
					\Route::any($page->getUri(), ['as' => $page->getName(), 'uses' => $page->uses]);
			}
		}

	}

	/**
	 * @return HasOne
	 */
	public function parent()
	{
		return $this->belongsTo('Intelitkz\Laraveltools\Page', 'parent_id');
	}

	/**
	 * @return self
	 */
	public function children()
	{
		return $this->hasMany('Intelitkz\Laraveltools\Page', 'parent_id');
	}

	public static function setBreadcrumbs()
	{
		if (!\Schema::hasTable('pages'))
			return false;

		/**
		 * @var $page Page
		 */
		foreach (self::all() as $page)
		{
			\Breadcrumbs::register($page->getName(), function($breadcrumbs) use ($page)
			{
				($parent = $page->parent()->getResults())
					? $breadcrumbs->parent($page->parent()->getResults()->getName())
					: ($page->getName() != 'getHome' && $breadcrumbs->parent('getHome'));

				$breadcrumbs->push($page->getTitle(), $page->getUri());
			});
		}
	}
}
