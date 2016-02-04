<?php
namespace Intelitkz\Laraveltools;

use Intelitkz\Laraveltools\Models\Page;

class Pages
{
    private static $pages;

    public static function getPages()
    {
        if (self::$pages)
            return self::$pages;

        if ( ! \Schema::hasTable('pages'))
            return [];

        return self::$pages = Page::all();
    }

    public static function setRoutes()
    {
        /**
         * @var $page Page
         */
        foreach (self::getPages() as $page)
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
            }
        }
    }

    public static function setBreadcrumbs()
    {
        /**
         * @var $page Page
         */
        foreach (self::getPages() as $page)
        {
            \Breadcrumbs::register($page->getName(), function($breadcrumbs) use ($page)
            {
                $page->parent
                    ? $breadcrumbs->parent($page->parent)
                    : ($page->name != 'home' && $breadcrumbs->parent('home'));

                $breadcrumbs->push(trans('pages.'.$page->name), $page->getUri());
            });
        }
    }

    /**
     * @param $page object|string
     * @return string|\Symfony\Component\Translation\TranslatorInterface
     */
    public static function getTitle($page)
    {
        $name = is_object($page) ? $page->name : $page;

        return trans('pages.'.$name);
    }

    public static function getApiPages()
    {
        return [
            'apiContractContent' => ['url' => 'api/contract/content', 'uses' => 'Api\ContractsController@getContract']
        ];
    }

    public static function setApiRoutes()
    {
        \Route::get('api/contract/content', ['as' => 'apiContractContent', 'uses' =>
            'Api\ContractsController@getContract']);
    }
}
