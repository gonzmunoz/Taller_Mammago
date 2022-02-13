<!DOCTYPE html>
<html>
<head>
    <title>{{ trans('messages.mammago') }}</title>
</head>
<body>
<h1>{{ $details['title'] }}</h1>
<p>{{ $details['user_name'] }}</p>
<a href="{{ $details['body'] }}">{{ trans('messages.confirmAccount') }}</a>
</body>
</html>
