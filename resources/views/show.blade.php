@extends('mail-view::base')

@section('content')

    <div class="my-6">
        <a class="text-gray-700 hover:text-gray-900" href="{{ route('mail-view.index') }}">← Back to list</a>
    </div>

    <div class="bg-white rounded shadow overflow-x-auto max-w-6xl px-4 py-6">

        <h1 class="text-3xl font-bold mb-12">{{ $title }}</h1>


        <ul class="space-y-2">

            @if(count($from) == 1 && count($fromAddresses = $from[0]->getNameAddressStrings()) <= 1)
                <li><strong>From:</strong> @foreach($fromAddresses as $fromAddress) {{ $fromAddress }} @endforeach</li>
            @else
                <li class="text-red-700">There is multiple <i>from</i> header, please look at the full headers below.</li>
            @endif

            @if(count($subject) == 1)
                <li><strong>Subject:</strong> {{ $subject[0]->getValue() }}</li>
            @else
                <li class="text-red-700">There is multiple <i>subject</i> header, please look at the full headers below.</li>
            @endif
        </ul>


        <details class="mt-8">
            <summary>See all headers</summary>
            <ul class="space-y-1 mt-3">
                @foreach($headers as $header)
                    <li>{{ $header }}</li>
                @endforeach
            </ul>
        </details>

        <details class="mt-8">
            <summary>Show preview code</summary>
            <p class="mt-3">This is the code used to generate this email template</p>
            <pre>
                <ul class="space-y-1 mt-3 font-mono">@foreach($attributes['source'] as $line)<li>{{ $line }}</li>@endforeach</ul>
            </pre>
            <p class="text-gray-600">{{ $attributes['file'] }}</p>
        </details>

    </div>

    <div class="mt-10 mb-12 border-dotted border-2 border-gray-800">
        {!! $body !!}
    </div>

@endsection
