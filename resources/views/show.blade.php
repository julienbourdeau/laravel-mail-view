<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body style="padding: 36px;">

    <h1>{{ $title }}</h1>


    @if(count($from) == 1 && count($fromAddresses = $from[0]->getNameAddressStrings()) <= 1)

        <p><strong>From:</strong> @forelse($fromAddresses as $fromAddress) {{ $fromAddress }} @empty No from address set @endforelse</p>

    @else
        <p style="color: red;">There is multiple <i>from</i> header, please look at the full headers below.</p>
    @endif

    @if(count($subject) == 1)
        <p><strong>Subject:</strong> {{ $subject[0]->getValue() }}</p>
    @else
        <p style="color: red;">There is multiple <i>subject</i> header, please look at the full headers below.</p>
    @endif


    <details>
        <summary>Full headers</summary>
        <ul style="list-style-type: none">
            @foreach($headers as $header)
                <li>{{ $header }}</li>
            @endforeach
        </ul>
    </details>

    <div style="border: 2px dotted black; margin: 32px 0">
        {!! $body !!}
    </div>
</body>
</html>
