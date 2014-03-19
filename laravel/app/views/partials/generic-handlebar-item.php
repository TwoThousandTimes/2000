<script id="featured-template" type="text/x-handlebars-template">
	<div class="generic-item">
		<header>
			<h3><a href="{{url}}/posts/{{post.alias}}">{{post.title}}</a></h3> 
			<span class="story-type">{{post.story_type}}</span>
			<span class="author"><span>by</span> <a href="{{url}}/profile/{{user.username}}">{{user.username}}</a></span>
		</header>
		<section>
			<div class="the-image">
				<a href="{{url}}/posts/{{post.alias}}" style="background-image: url('{{url}}/uploads/final_images/{{post.image}}');">
				
				</a>
			</div>
			<div class="the-tags">
				{{post.tagline_1}} | 
				{{post.tagline_2}} | 
				{{post.tagline_3}}
			</div>
		</section>
	</div>
</script>