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
					'method'     => 'get',
					'name'       => 'home',
					'uses'       => 'HomeController@index',
					'uri_prefix' => '',
					'uri_suffix' => '',
					'custom_uri' => '/',
					'parent'     => '',
					'in_menu'    => 1
				],
				[
					'method'     => 'get',
					'name'       => 'finance',
					'uses'       => 'FinanceController@index',
					'uri_prefix' => '',
					'uri_suffix' => '',
					'custom_uri' => '',
					'parent'     => '',
					'in_menu'    => 1
				],
				[
					'method'     => 'get',
					'name'       => 'contracts',
					'uses'       => 'ContractsController@index',
					'uri_prefix' => '',
					'uri_suffix' => '',
					'custom_uri' => '',
					'parent'     => '',
					'in_menu'    => 1
				],
				[
					'method'     => 'get',
					'name'       => 'contract',
					'uses'       => 'ContractsController@edit',
					'uri_prefix' => '',
					'uri_suffix' => '',
					'custom_uri' => '',
					'parent'     => 'getContracts',
					'in_menu'    => 0
				],
				[
					'method'     => 'post',
					'name'       => 'contract',
					'uses'       => 'ContractsController@edit',
					'uri_prefix' => '',
					'uri_suffix' => '',
					'custom_uri' => '',
					'parent'     => 'getContracts',
					'in_menu'    => 0
				],
				[
					'method'     => 'patch',
					'name'       => 'contract',
					'uses'       => 'ContractsController@edit',
					'uri_prefix' => '',
					'uri_suffix' => '',
					'custom_uri' => '',
					'parent'     => 'getContracts',
					'in_menu'    => 0
				],
				[
					'method'     => 'get',
					'name'       => 'contractContent',
					'uses'       => 'Api\ContractsController@getContract',
					'uri_prefix' => 'api/',
					'uri_suffix' => '',
					'custom_uri' => '',
					'parent'     => '',
					'in_menu'    => 0
				],
			]);
	}
}
