<?php
namespace App\Modules\Backend\Library;

use \Phalcon\Mvc\Model\Manager,
	\App\Modules\Frontend\Controllers\ProductsController,
	\App\Modules\Frontend\Controllers\ProductsOptionsController,
	\App\Modules\Frontend\Controllers\ChannelsController,
	\App\Modules\Frontend\Controllers\ChannelsOptionsController,
	\App\Modules\Frontend\Controllers\CompaniesController,
	\App\Modules\Frontend\Controllers\CompaniesOptionsController,
	\App\Modules\Frontend\Controllers\AreasController,
	\App\Modules\Frontend\Controllers\BrandsController,
	\App\Modules\Frontend\Controllers\CountryController,
	\App\Modules\Frontend\Controllers\CountryOptionsController,
	\App\Modules\Frontend\Controllers\OptionsController,
	\App\Modules\Frontend\Controllers\VerticalsController;

class CustomModelsManager extends Manager
{
	public function __construct(){
		
	}
	
	/**
	 * This is executed if the event triggered is 'afterCreate'
	 */
	public function afterCreate($event, $model)
	{
		switch (get_class($model)) {
			case 'App\Modules\Backend\Models\Products':
				$controller = new ProductsController();
				break;
			case 'App\Modules\Backend\Models\Verticals':
				$controller = new VerticalsController();
				break;
			case 'App\Modules\Backend\Models\Areas':
				$controller = new AreasController();
				break;
			case 'App\Modules\Backend\Models\Brands':
				$controller = new BrandsController();
				break;
			case 'App\Modules\Backend\Models\Companies':
				$controller = new CompaniesController();
				break;
			case 'App\Modules\Backend\Models\Channels':
				$controller = new ChannelsController();
				break;
			case 'App\Modules\Backend\Models\Country':
				$controller = new CountryController();
				break;
			case 'App\Modules\Backend\Models\Options':
				$controller = new OptionsController();
				break;
			case 'App\Modules\Backend\Models\ChannelsOptions':
				$controller = new ChannelsOptionsController();
				break;
			case 'App\Modules\Backend\Models\CompaniesOptions':
				$controller = new CompaniesOptionsController();
				break;
			case 'App\Modules\Backend\Models\CountryOptions':
				$controller = new CountryOptionsController();
				break;
			case 'App\Modules\Backend\Models\ProductsOptions':
				$controller = new ProductsOptionsController();
				break;
		}
		if (isset($controller)){
			$controller->post($model->id);
		}
	}
	
	/**
	 * This is executed if the event triggered is 'afterUpdate'
	 */
	public function afterUpdate($event, $model) {
		$method = $this->getDI()->get('request')->getMethod();
		if ('DELETE' == $method) {
			$this->afterDelete($event, $model);
		} else {
			switch (get_class($model)) {
				case 'App\Modules\Backend\Models\Verticals':
					$verticalId = $model->id;
					$controller = new VerticalsController();
					$controller->put($verticalId);
					break;
				case 'App\Modules\Backend\Models\Channels':
					$channelId = $model->id;
					$channel = new ChannelsController();
					$channel->put($channelId);
					break;
				case 'App\Modules\Backend\Models\ChannelsOptions':
					$channelsOptionId = $model->id;
					$channelsOption = new ChannelsOptionsController();
					$channelsOption->put($channelsOptionId);
					break;
				case 'App\Modules\Backend\Models\Companies':
					$companyId = $model->id;
					$companies = new CompaniesController();
					$companies->put($companyId);
					break;
				case 'App\Modules\Backend\Models\CompaniesOptions':
					$companiesOptionId = $model->id;
					$companiesOption = new CompaniesOptionsController();
					$companiesOption->put($companiesOptionId);
					break;
				case 'App\Modules\Backend\Models\Brands':
					$brandId = $model->id;
					$brand = new BrandsController();
					$brand->put($brandId);
					break;
				case 'App\Modules\Backend\Models\Products':
					$products = new ProductsController();
					$products->put($model->id);
					break;
				case 'App\Modules\Backend\Models\Areas':
					$areaId = $model->id;
					$area = new AreasController();
					$area->put($areaId);
					break;
				case 'App\Modules\Backend\Models\ProductsOptions':
					$productsOptionId = $model->id;
					$productsOption = new ProductsOptionsController();
					$productsOption->put($productsOptionId);
					//$products->put(0, $channelId, $brandId, $companyId, $areaId, $channelsOptionId, $companiesOptionId);
					break;
			    case 'App\Modules\Backend\Models\Country':
					$countryOptionId = $model->id;
					$countryOptions = new CountryOptionsController();
					$countryOptions->put($countryOptionId);
					break;
				case 'App\Modules\Backend\Models\CountryOptions':
					$country = new CountryController();
					$country->put($model->id, $countryOptionId);
					break;
			}
		}
	}
	
	/**
	 * This is executed if the event triggered is 'beforeDelete'
	 */
	public function beforeDelete($event, $model) {
		
	}
	
	/**
	 * This is executed if the event triggered is 'afterDelete'
	 */
	public function afterDelete($event, $model) {
		
		switch (get_class($model)) {
			case 'App\Modules\Backend\Models\Products':
				$controller = new ProductsController();
				break;
			case 'App\Modules\Backend\Models\Areas':
				$controller = new AreasController();
				break;
			case 'App\Modules\Backend\Models\Brands':
				$controller = new BrandsController();
				break;
			case 'App\Modules\Backend\Models\Companies':
				$controller = new CompaniesController();
				break;
			case 'App\Modules\Backend\Models\Channels':
				$controller = new ChannelsController();
				break;
			case 'App\Modules\Backend\Models\Country':
				$controller = new CountryController();
				break;
			case 'App\Modules\Backend\Models\Options':
				$controller = new OptionsController();
				break;
			case 'App\Modules\Backend\Models\ChannelsOptions':
				$controller = new ChannelsOptionsController();
				break;
			case 'App\Modules\Backend\Models\CompaniesOptions':
				$controller = new CompaniesOptionsController();
				break;
			case 'App\Modules\Backend\Models\CountryOptions':
				$controller = new CountryOptionsController();
				break;
			case 'App\Modules\Backend\Models\ProductsOptions':
				$controller = new ProductsOptionsController();
				break;
			case 'App\Modules\Backend\Models\Verticals':
				$controller = new VerticalsController();
				break;
				
		}
		if (isset($controller)){
			$controller->delete($model->id);
		}
	}
}