{{--This is both the activity and my post item.--}}

<div class="col-md-4 post-id-{{$act->post->id}}">
	<div class="generic-item activity equal-height {{$act->post_type}}">
		<header>
			@if($act->post_type == 'post')
				<h3 class="post">
					{{ link_to('posts/'.$act->post->alias, $act->post->title) }}
				</h3>
				<span class="author">by {{ link_to('profile/'.$act->post->user->username, $act->post->user->username) }}</span> 
			@elseif($act->post_type == 'repost')
				<h3 class="repost">
					{{ link_to('posts/'.$act->post->alias, $act->post->title) }}
				</h3>
				<span class="author">by {{ link_to('profile/'.$act->post->user->username, $act->post->user->username) }}</span>
				<span class="repost">reposted by {{ link_to('profile/'.$act->user->username, $act->user->username) }}</span>
			@else
				<!--{{$act->post_type}}-->
				<h3 class="favorite ">{{ link_to('posts/'.$act->post->alias, $act->post->title) }}</h3>
				<span class="author">by {{ link_to('profile/'.$act->post->user->username, $act->post->user->username) }}</span>
				<span><a class="favorite" data-post="{{$act->post->id}}">unfavorite</a></span>
			@endif
			
			{{--If you are the owner of this post show menu options--}}
			@if(Auth::user()->id == $act->post->user->id && 
				strtotime(date('Y-m-d H:i:s', strtotime('-72 hours'))) <= strtotime($act->post->created_at) &&
				$act->post_type == 'post'
				)
				<ul class="user-menu">
					<li class="options">
						<a href="#post-edit">
							Options
						</a>
						<ul class="menu-listing">
							<li class="edit">
								<a href="{{Config::get('app.url')}}/profile/editpost/{{$act->post->id}}">Edit</a>
							</li>
							{{--Check out the fact that below has a hidden function --}}
							<li class="feature @if($act->post->id != Session::get('featured')) @else hidden @endif">
								<a href="#feature" data-id="{{$act->post->id}}">Feature</a>
							</li>
							
							<li class="delete">
								<a href="#delete" data-id="{{$act->post->id}}">Delete</a>
							</li>
						</ul>
					</li>
				</ul>
			@endif
		</header>
		<section>
			<div class="the-image">
				<a href="{{URL::to('posts/'.$act->post->alias)}}">
					<img src="{{Config::get('app.url')}}/uploads/final_images/{{$act->post->image}}">
				</a>
			</div>
			<div class="the-tags">
				{{$act->post->tagline_1}} |
				{{$act->post->tagline_2}} |
				{{$act->post->tagline_3}}
			</div>
		</section>
	</div>
</div>