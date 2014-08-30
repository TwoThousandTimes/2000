
<script type="text/javascript">
	Handlebars.registerHelper('ifCond', function(v1, v2, options) {
		if(v1 === v2) {
			return options.fn(this);
		}
			return options.inverse(this);
		}
	);
</script>

<script type="text/x-handlebars-template" id="comment-template">

	<div id="comment-{{ comment._id }}" class="comment {{#ifCond comment.published 1}}published{{else}}deleted{{/ifCond}} {{#ifCond comment.depth 0}}thread-parent{{/ifCond}}" style="margin-left: {{ comment.margin }}">
		<span>by <a href="{{ profile_url }}{{ comment.author.username }}"> {{ comment.author.username }} </a> </span>
		
		<p class="comment-body">
			{{#ifCond comment.published 0 }}
				<span class="deleted">(This comment has been deleted)</span>
			{{else}}
				 {{ comment.body }} 	
			{{/ifCond}}
		</p>

		<a class="reply {{#ifCond active_user_id false}}auth{{/ifCond}} btn-flat-white" data-replyid="{{ comment._id }}" data-postid="{{ comment.post_id }}">Reply</a>
		
		{{#ifCond comment.author.user_id active_user_id }}
			{{#ifCond comment.published 1}}			
				<a class="delete btn-flat-dark-gray" data-delid="{{ comment._id }}" title="Delete Comment" >Delete</a>
			{{/ifCond}}
		{{/ifCond}}

		{{#ifCond is_mod true }}
			{{#ifCond comment.published 1}}
				<a class="delete mod-del-comment btn-flat-dark-gray" data-delid="{{ comment._id }}" title="Delete Comment" >Moderator Delete </a>
			{{/ifCond}}
		{{/ifCond}}

		<div class="reply-box"></div>
	</div>

</script>