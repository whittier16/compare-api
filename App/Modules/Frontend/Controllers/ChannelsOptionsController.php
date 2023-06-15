<?php
namespace App\Modules\Frontend\Controllers;

use App\Modules\Backend\Models\ChannelsOptions,
	App\Modules\Frontend\Models\ChannelsOptions as ChannelsOptionsCollection,
	App\Modules\Frontend\Models\Channels as Channels,
	App\Common\Lib\Application\Controllers\RESTController;

class ChannelsOptionsController extends RESTController{

	/**
	 * Responds with information about newly inserted channels option
	 *
	 * @method post
	 * @return json/xml data
	 */
	public function post($id){
		$channelsOption = ChannelsOptions::findFirstById($id);
		if ($channelsOption){
			$channelsOptionCollection = new ChannelsOptionsCollection();
			$channelsOptionCollection->id = $channelsOption->id;
			$channelsOptionCollection->channelId = $channelsOption->channelId;
			$channelsOptionCollection->name = $channelsOption->name;
			$channelsOptionCollection->value = $channelsOption->value;
			$channelsOptionCollection->label = $channelsOption->label;
			$channelsOptionCollection->status = $channelsOption->status;
			$channelsOptionCollection->active = $channelsOption->active;
			$channelsOptionCollection->editable = $channelsOption->editable;
			$channelsOptionCollection->visibility = $channelsOption->visibility;
			$channelsOptionCollection->created = $channelsOption->created;
			$channelsOptionCollection->modified = $channelsOption->modified;
			$channelsOptionCollection->createdBy = $channelsOption->createdBy;
			$channelsOptionCollection->modifiedBy = $channelsOption->modifiedBy;
			$success = $channelsOptionCollection->save();
			if ($success){
				if (1 == $channelsOption->status){
					$channels = Channels::findFirst(array(array('id' => $channelsOption->channelId)));
					if ($channels){
						$name = $channelsOption->name;
						$channels->$name = $channelsOption->value;
						$channels->save();
						$results['id'] = $channelsOption->id;
					}
				}
			}
		}
		return $channelsOption->id;
	}
	
	/**
	 * Responds with information about deleted record
	 *
	 * @method delete
	 * @return json/xml data
	 */
	public function delete($id){
		$results = array();
		$channelsOption = ChannelsOptions::findFirstById($id);
		if ($channelsOption != false){
			$channelsOptionCollection = ChannelsOptionsCollection::findFirst(array(array('id' => $id)));
			if ($channelsOptionCollection != false){
				$channelsOptionCollection->status = $channelsOption->status;
				$channelsOptionCollection->active = $channelsOption->active;
				$channelsOptionCollection->editable = $channelsOption->editable;
				$channelsOptionCollection->visibility = $channelsOption->visibility;
				$channelsOptionCollection->modified = $channelsOption->modified;
				$channelsOptionCollection->modifiedBy = $channelsOption->modifiedBy;
				$success = $channelsOptionCollection->save();
				if ($success){
					if (1 == $channelsOption->status){
						$channels = Channels::findFirst(array(array('id' => $channelsOption->channelId)));
						if ($channels){
							$name = $channelsOption->name;
							unset($channels->$name);
							$channels->save();
							$results['id'] = $channelsOption->id;
						}
					}
				}
			}
		}
		return $results;
	}
 	
	/**
	 * Responds with information about updated inserted channels option
	 *
	 * @method put
	 * @return json/xml data
	 */
	public function put($id){
		$results = array();
		$channelsOption = ChannelsOptions::findFirstById($id);
		if ($channelsOption){
			$channelsOptionCollection = ChannelsOptionsCollection::findFirst(array(array('id' => $id)));
			if ($channelsOptionCollection != false) {
				$channelsOptionCollection->id = $channelsOption->id;
				$channelsOptionCollection->channelId = $channelsOption->channelId;
				$channelsOptionCollection->name = $channelsOption->name;
				$channelsOptionCollection->value = $channelsOption->value;
				$channelsOptionCollection->label = $channelsOption->label;
				$channelsOptionCollection->status = $channelsOption->status;
				$channelsOptionCollection->active = $channelsOption->active;
				$channelsOptionCollection->editable = $channelsOption->editable;
				$channelsOptionCollection->visibility = $channelsOption->visibility;
				$channelsOptionCollection->created = $channelsOption->created;
				$channelsOptionCollection->modified = $channelsOption->modified;
				$channelsOptionCollection->createdBy = $channelsOption->createdBy;
				$channelsOptionCollection->modifiedBy = $channelsOption->modifiedBy;
				$success = $channelsOptionCollection->save();
				if ($success){
					if (1 == $channelsOption->status){
						$channels = Channels::findFirst(array(array('id' => $channelsOption->channelId)));
						if ($channels){
							$name = $channelsOption->name;
							$channels->$name = $channelsOption->value;
							$channels->save();
							$results['id'] = $channelsOption->id;
						}
					}
				}
			}	
		}
		return $results;
	}
}