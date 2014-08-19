<?php

use \App;

/**
 * User Queue Actions
 */
class UserAction {
	
	/**
	 * Constructor
	 */
	public function __construct() {
		$this->post = App::make('AppStorage\Post\PostRepository');
		$this->not = App::make('AppStorage\Notification\NotificationRepository');
		$this->follow = App::make('AppStorage\Follow\FollowRepository');
		$this->activity = App::make('AppStorage\Activity\ActivityRepository');
		$this->feed = App::make('AppStorage\Feed\FeedRepository');
	}
	
	/**
	 * Notify all followers that you reposted
	 * @param object $job the queue job object.
	 * @param array $data Data that's needed for the job.
	 */
	function repost($job, $data) {
		
		//Grab all the followers for this user
		$followers = $this->follow->followersByUserId($data['user_id']);

		$post = $this->post->findById($data['post_id']);
		
		$action_user = User::where('id', $data['user_id'])->first();
		
			//process notification for each follower
			foreach($followers as $follower) {
				
				$not = $this->not->find(
									$data['post_id'], //Post id	
									$follower->follower_id, //person getting notified
									'repost'
									);
									
				//If the Notifiation does not exist, 
				if(!$not) {
					$not_data = array(
						'post_id' => $data['post_id'],
						'post_title' => $post->title,
						'post_alias' => $post->alias,
						'user_id'    => $follower->follower_id,
						'noticed'    => 0,
						'notification_type' => 'repost'
						);
					$not = $this->not->create($not_data);
				}
				$this->not->pushUsers($not, $data['username']);
				
				//below statement is to ensure that the user who owns the content doesn't get the repost.
				if($follower->follower_id != $post->user->id) {
					$activity = array(
							'action_id' => $data['user_id'],
							'user_id' => $follower->follower_id,
							'post_id' => $data['post_id'],
							'post_type' => 'repost'
							);					
					$this->activity->create($activity);

					//New Feed System replaces the old activity;
					$new_feed = array(
							'user_id' => $follower->follower_id,
							'post_title' => $post->title,
							'post_id' => $data['post_id'],
							'feed_type' => 'repost',
							'users' => $action_user->username
							);
					$this->feed->create($new_feed);
				}
			}
		$job->delete();
	}

	/**
	 * Deletes reposts
	 * @param object $job the queue job object.
	 * @param array $data Data that's needed for the job.
	 */
	function delrepost($job, $data) {
		
		//Grab all the followers for this user
		$followers = $this->follow->followersByUserId($data['user_id']);
		
		$post = $this->post->findById($data['post_id']);
		
		$action_user = User::where('id', $data['user_id'])->first();
		
		//process notification for each follower
		foreach($followers as $follower) {
			$not = $this->not->find(
							$data['post_id'], 
							$follower->follower_id, 
							'repost'
							);

			//pull the user out of notifications.
			$this->not->pullUsers($not, $action_user->username);
			
			//below statement is to ensure that the user who owns the content doesn't get the repost.
			if($follower->follower_id != $post->user->id) {
				$activity = array(
						'action_id' => $data['user_id'],
						'user_id' => $follower->follower_id,
						'post_id' => $data['post_id'],
						'post_type' => 'repost'
					);
				$this->activity->delete($activity);

				$del_feed = array(
						'user_id' => $follower->follower_id,
						'post_id' => $data['post_id'],
						'feed_type' => 'repost',
						'users' => $action_user->username
						);
				$this->feed->delete($del_feed);
			}
		}
		$job->delete();
	}

	
	/**
	 * Let's everyone know you posted something new to your followers
	 * @param object $job the queue job object.
	 * @param array $data Data that's needed for the job.
	 */
	function newpost($job, $data) {
		//Grab all the followers for this user
		$followers = $this->follow->followersByUserId($data['user_id']);
		
		$post = $this->post->findById($data['post_id']);
		
		//process notification for each follower
		foreach($followers as $follower) {
			
			$not = $this->not->find(
								$data['post_id'],
								$follower->follower_id,
								'post'
								);
				
			if($not != false) {
				$not_data = array(
					'post_id' => $data['post_id'],
					'post_title' => $post->title,
					'post_alias' => $post->alias,
					'user_id'    => $follower->follower_id,
					'noticed'    => 0,
					'notification_type' => 'post'
					);
				$not = $this->not->create($not_data);
			}

			$this->not->pushUsers($not, $data['username']);

			$activity = array(
						'action_id' => $data['user_id'],
						'user_id' => $follower->follower_id,
						'post_id' => $data['post_id'],
						'post_type' => 'post'
						);					
			$this->activity->create($activity);

			$new_feed = array(
					'user_id' => $follower->follower_id,
					'post_title' => $post->title,
					'post_id' => $data['post_id'],
					'feed_type' => 'post',
					'users' => $data['username']
					);
			$this->feed->create($new_feed);

		}
		
		$job->delete();
		
	}
	
}