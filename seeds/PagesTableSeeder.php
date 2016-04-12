<?php

use Illuminate\Database\Seeder;

class PagesTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('pages')->insert(
			[
				[
					'id'         => 1,
					'method'     => 'get',
					'name'       => 'home',
					'uses'       => 'HomeController@index',
					'uri_prefix' => '',
					'uri_suffix' => '',
					'custom_uri' => '/',
					'parent_id'  => null,
					'in_menu'    => 1
				],
				[
					'id'         => 2,
					'method'     => 'get',
					'name'       => 'finance',
					'uses'       => 'FinanceController@index',
					'uri_prefix' => '',
					'uri_suffix' => '',
					'custom_uri' => '',
					'parent_id'  => null,
					'in_menu'    => 1
				],
				[
					'id'         => 3,
					'method'     => 'get',
					'name'       => 'contracts',
					'uses'       => 'ContractsController@index',
					'uri_prefix' => '',
					'uri_suffix' => '',
					'custom_uri' => '',
					'parent_id'  => null,
					'in_menu'    => 1
				],
				[
					'id'         => 4,
					'method'     => 'get',
					'name'       => 'contract',
					'uses'       => 'ContractsController@edit',
					'uri_prefix' => '',
					'uri_suffix' => '',
					'custom_uri' => '',
					'parent_id'  => 3,
					'in_menu'    => 0
				],
				[
					'id'         => 5,
					'method'     => 'post',
					'name'       => 'contract',
					'uses'       => 'ContractsController@edit',
					'uri_prefix' => '',
					'uri_suffix' => '',
					'custom_uri' => '',
					'parent_id'  => 3,
					'in_menu'    => 0
				],
				[
					'id'         => 6,
					'method'     => 'patch',
					'name'       => 'contract',
					'uses'       => 'ContractsController@edit',
					'uri_prefix' => '',
					'uri_suffix' => '',
					'custom_uri' => '',
					'parent_id'  => 3,
					'in_menu'    => 0
				],
				[
					'id'         => 7,
					'method'     => 'get',
					'name'       => 'contractContent',
					'uses'       => 'Api\ContractsController@getContract',
					'uri_prefix' => 'api/',
					'uri_suffix' => '',
					'custom_uri' => '',
					'parent_id'  => null,
					'in_menu'    => 0
				],
				[
					'id'         => 8,
					'method'     => 'get',
					'name'       => 'tasks',
					'uses'       => 'TasksController@index',
					'uri_prefix' => '',
					'uri_suffix' => '',
					'custom_uri' => '',
					'parent_id'  => 1,
					'in_menu'    => 1
				],
				[
					'id'         => 9,
					'method'     => 'get',
					'name'       => 'task',
					'uses'       => 'TasksController@edit',
					'uri_prefix' => '',
					'uri_suffix' => '',
					'custom_uri' => '',
					'parent_id'  => 8,
					'in_menu'    => 0
				],
				[
					'id'         => 10,
					'method'     => 'get',
					'name'       => 'projects',
					'uses'       => 'ProjectsController@index',
					'uri_prefix' => '',
					'uri_suffix' => '',
					'custom_uri' => '',
					'parent_id'  => 1,
					'in_menu'    => 1
				],
				[
					'id'         => 11,
					'method'     => 'get',
					'name'       => 'packages',
					'uses'       => 'PackagesController@index',
					'uri_prefix' => '',
					'uri_suffix' => '',
					'custom_uri' => '',
					'parent_id'  => 1,
					'in_menu'    => 1
				],
				[
					'id'         => 12,
					'method'     => 'get',
					'name'       => 'clients',
					'uses'       => 'ClientsController@index',
					'uri_prefix' => '',
					'uri_suffix' => '',
					'custom_uri' => '',
					'parent_id'  => 1,
					'in_menu'    => 1
				],
				[
					'id'         => 13,
					'method'     => 'get',
					'name'       => 'client',
					'uses'       => 'ClientsController@edit',
					'uri_prefix' => '',
					'uri_suffix' => '',
					'custom_uri' => '',
					'parent_id'  => 12,
					'in_menu'    => 0
				],
			]);
	}
}
