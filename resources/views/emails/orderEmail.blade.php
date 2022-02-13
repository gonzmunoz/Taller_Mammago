<!DOCTYPE html>
<html>
<head>
    <title>{{ trans('messages.mammago') }}</title>
</head>
<body>
<h3>{{ trans('messages.orderReceipt') . ' ' . date('d-m-Y',  substr(strtotime(\Carbon\Carbon::now()), 0, 10)) }}</h3>
</body>
</html>
