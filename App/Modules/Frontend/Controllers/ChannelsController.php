<?php
namespace App\Modules\Frontend\Controllers;

use App\Modules\Backend\Models\Channels,
	App\Modules\Frontend\Models\Channels as ChannelsCollection,
	App\Common\Lib\Application\Controllers\RESTController;

class ChannelsController extends RESTController{

	/**
	 * Responds with information about newly inserted channel
	 *
	 * @method post
	 * @return json/xml data
	 */
	public function post($id){
		$channel = Channels::findFirstById($id);
		if ($channel){
			$channelCollection = new ChannelsCollection();
			$channelCollection->id = $channel->id;
			$channelCollection->verticalId = $channel->verticalId;
			$channelCollection->name = $channel->name;
			$channelCollection->description = $channel->description;
			$channelCollection->alias = $channel->alias;
			$channelCollection->revenueValue = $channel->revenueValue;
			$channelCollection->perPage = $channel->perPage;
			$channelCollection->active = $channel->active;
			$channelCollection->status = $channel->status;
			$channelCollection->created = $channel->created;
			$channelCollection->modified = $channel->modified;
			$channelCollection->createdBy = $channel->createdBy;
			$channelCollection->modifiedBy = $channel->modifiedBy;
			$channelCollection->save();
			$results['id'] = $channel->id;
		}
		
		return $channel->id;
	}
	
	/**
	 * Responds with information about deleted record
	 *
	 * @method delete
	 * @return json/xml data
	 */
	public function delete($id){
		$results = array();
		$channel = Channels::findFirstById($id);
		if ($channel != false){
			$channelsCollection = ChannelsCollection::findFirst(array(array('id' => $id)));
			if ($channelsCollection != false){
				$channelsCollection->status = $channel->status;
				$channelsCollection->active = $channel->active;
				$channelsCollection->modified = $channel->modified;
				$channelsCollection->modifiedBy = $channel->modifiedBy;
				$channelsCollection->save();
				$results['id'] = $channel->id;
			}
		}
		return $results;
	}
 	
	/**
	 * Responds with information about updated inserted channel
	 *
	 * @method put
	 * @return json/xml data
	 */
	public function put($id){
		$results = array();
		$channel = Channels::findFirstById($id);
		if ($channel){
			$channelCollection = ChannelsCollection::findFirst(array(array('id' => $id)));
			if ($channelCollection != false){
				$channelCollection->id = $channel->id;
				$channelCollection->verticalId = $channel->verticalId;
				$channelCollection->name = $channel->name;
				$channelCollection->description = $channel->description;
				$channelCollection->alias = $channel->alias;
				$channelCollection->revenueValue = $channel->revenueValue;
				$channelCollection->perPage = $channel->perPage;
				$channelCollection->active = $channel->active;
				$channelCollection->status = $channel->status;
				$channelCollection->created = $channel->created;
				$channelCollection->modified = $channel->modified;
				$channelCollection->createdBy = $channel->createdBy;
				$channelCollection->modifiedBy = $channel->modifiedBy;
				$channelCollection->save();
				$results['id'] = $channel->id;
			}
		}
		return $results;
	}
}