<?php namespace Intelitkz\Laraveltools\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Page
 *
 * @property integer $id
 * @property string $method
 * @property string $name
 * @property string $uses
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

	protected $name;

	public function getUri()
	{
		$uri = $this->method.ucfirst($this->name);

		return $uri;
	}

	public function getName()
	{
		return $this->method.ucfirst($this->name);
	}




}
