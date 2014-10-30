@extends('v2.emails.email_layout')

@section('content')

<h1 style="margin-top:50px; color:#000000; font-family:Helvetica Neue,Helvetica,Arial,sans-serif; font-weight:bold; font-size:21px;">{{$parent_user->username}},</h1>

<p style="color:#000000; font-family: Baskerville,Baskerville Old Face,Hoefler Text, Garamond,Times New Roman,Gerogia,serif; font-weight:normal; font-size:16px;">{{$user->username}} has replied to your comment “{{ Str::limit(strip_tags($parent->body),30) }}” on “{{$parent->post->title}}” To view {{$user->username}}’s comment, click <a href="{{URL::to('posts/'.$comment->post->alias . '#comment-'. $comment->_id )}}">here</a>.</p>

<p style="color:#000000; font-family: Baskerville,Baskerville Old Face,Hoefler Text, Garamond,Times New Roman,Gerogia,serif; font-weight:normal; font-size:10px;">You can edit your email notifications in account settings.</p>

@stop