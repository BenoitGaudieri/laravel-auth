{{-- <h1>New post published!</h1>

<p>This post has been published:</p>

<p><strong>Title: {{ $title }}</strong></p>
<p><strong>Body: {{ $body }}</strong></p> --}}

@component('mail::message')
## New post created

a new post has been punblished:

@component('mail::button', ["url" => config("app.url") . "/posts"])
View blog archive
    
@endcomponent

Thanks <br>
{{ config("app.name") }}
@endcomponent