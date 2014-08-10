<?php namespace AppStorage\Notification;

use Motification ,DB, Request;

class MoloquentNotificationRepository implements NotificationRepository {

	public function __construct(Motification $notification)
	{
		$this->not = $notification;
	}
	
	public function instance() {
		return new Motification;
	}
	
	public function input($user_id) {}

	//Create
	public function create($input) {}

	/**
	 * Returns a notification object if it exists
	 * @param integer $post_id Post ID
	 * @param integer $user_id User ID
	 * @param string $type Notification Type 
	 */
	public function find($post_id, $user_id, $type) {
		$not = $this->not->where('post_id', $post_id)//Post id
					->where('user_id', $user_id)//person getting notified
					->where('notification_type', $type);
		return self::count_check($not);
	}
	
	public function findById($id) {}
	
	
		private function count_check($not) {
			if($not->count()) {
				return $not;
			} else {
				return false;
			}
		}
	
	
	//Read Multi
	public function all() {}
	
	public function allDesc($user_id) {
		return $this->not->where('user_id', $user_id)
							->orderBy('created_at','DESC')
							->get();
	}
	
	//Below is a temporary function until we go full async.
	public function limited($user_id) {
		return $this->not->where('user_id',$user_id)
							->where('notification_type', '!=', 'message')//message notification is different.
							->where('noticed',0)
							->take(7)//taking 7 for now.  We'll change this up when we do a full rest interfaced situation.
							->orderBy('updated_at', 'DESC')
							->get();
	}
	
	//Check
	public function check() {}

	//Update
	public function noticed($array, $user_id) {
		$this->not->where('user_id', $user_id)
					->whereIn('_id', $notification_ids)
					->update(array('noticed'=>1));
	}
	
	/**
	 * Delete a Notification
	 * @param integer $user_id User id for the receiving end
	 * @param integer $post_id Post associated with the notification
	 * @param string $username Username for the person giving the notificaiton
	 * @param string $type The type of Notificaiton
	 */
	public function delete($user_id, $post_id, $username,  $type) {
		$not = $this->not
					->where('user_id', intval($user_id))//sometimes request stuff comes in as string.
					->where('user', $username)
					->where('notification_type', $type);
					if($type != 'follow'|| $post_id == null) {
						$not = $not->where('post_id', $post_id);
					}
					
		$not->delete();
	}
	
	
}