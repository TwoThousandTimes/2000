<form method="POST" action="{{{ (Confide::checkAction('UserController@store')) ?: URL::to('user')  }}}" accept-charset="UTF-8">
	
	@if ( Session::get('notice') )
		<div class="alert alert-yes">{{ Session::get('notice') }}</div>
	@endif
	
    <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
    <fieldset>
        <label for="username">{{{ Lang::get('confide::confide.username') }}}</label>
        <input id="username" placeholder="{{{ Lang::get('confide::confide.username') }}}" type="text" name="username" id="username" value="{{{ Input::old('username') }}}" maxlength="15" minlength="3" required>
		
		<div class="email-please">
			<a class="email-show">Verify account with your email?</a><span class="recommended"> You'll need to if you forget your password.</span>
		</div>
		
		<div class="email-group">
	        <label for="email">Email</label>
	        <input placeholder="Email" type="text" name="email" id="email" value="{{{ Input::old('email') }}}">
	        @if($errors->first('email'))
	        	<span class="error">{{$errors->first('email')}}</span>
	        @endif
		</div>
		
        <label for="password">Password</label>
        <input placeholder="Password" type="password" name="password" id="password" minlength="6">
        @if($errors->first('password'))
        	<span class="error">{{$errors->first('password')}}</span>
        @endif

        <label for="password_confirmation">Password Confirmation</label>
        <input placeholder="Password Confirmation" type="password" name="password_confirmation" id="password_confirmation" minlength="6" >
    	@if($errors->first('password_confirmation'))
        	<span class="error">{{$errors->first('password_confirmation')}}</span>
        @endif
		
		<br/>
		<br/>
		<img src="{{Captcha::img()}}"/><br/>
		<input type="text" name="captcha" placeholder="Captcha">
		@if($errors->first('captcha'))
        	<span class="error">{{$errors->first('captcha')}}</span>
        @endif
		
        <div class="form-actions">
          <button type="submit" class="btn">Submit</button>
        </div>

    </fieldset>
</form>