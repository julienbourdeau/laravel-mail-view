<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

    <h1>Mail View</h1>

    @forelse($mailViewCollection as $className => $methods)
        <h2>{{ class_basename($className) }}</h2>
        <ul>
            @forelse ($methods as $methodName)
                <li>
                    <a href="{{ route('mailview.show', [$className, $methodName]) }}">{{ $methodName }}</a>
                </li>
            @empty
                <li>No method found in {{ $className }}</li>
            @endforelse
        </ul>
    @empty
        No MailView class found. Create your first one is `tests/MailView` folder,
    @endforelse
</body>
</html>
