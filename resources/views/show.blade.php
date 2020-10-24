@extends('mail-view::base')

@section('content')

    <div class="my-6">
        <a class="text-gray-700 hover:text-gray-900" href="{{ route('mail-view.index') }}">← Back to list</a>
    </div>

    <div class="bg-white rounded shadow overflow-x-auto max-w-6xl px-4 py-6">

        <h1 class="text-3xl font-bold mb-12">{{ $title }}</h1>

        <ul class="space-y-2 mb-12">

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


        <details class="mb-8">
            <summary>See all headers</summary>
            <ul class="space-y-1 mt-3 ml-4">
                @foreach($headers as $header)
                    <li>{{ $header }}</li>
                @endforeach
            </ul>
        </details>

        <details class="mb-44">
            <summary>Show preview code</summary>
            <div class="mt-3 ml-4">
                This is the code used to generate this email template
                <pre class="mt-3 font-mono">
                    <code class="php">
                    <ul class="space-y-1">@foreach($attributes['source'] as $line)<li>{{ $line }}</li>@endforeach</ul>
                    </code>
                </pre>
                <p class="text-gray-600">{{ $attributes['file'] }}</p>
            </div>
        </details>

    </div>

    <div class="mt-10 mb-12" x-data>

        <div class="relative z-0 inline-flex mb-4 shadow rounded">

            @foreach($breakpoints as $label => $value)
                @php
                    $activeClasses = 'bg-gray-100 text-gray-700'; // TODO: figure it out
                    if ($loop->first) {
                        $classes = 'relative inline-flex items-center px-4 py-2 rounded-l bg-white text-xs leading-5 font-medium text-gray-700 hover:text-black focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150';
                    } elseif ($loop->last) {
                        $classes = '-ml-px relative inline-flex items-center px-4 py-2 rounded-r bg-white text-xs leading-5 font-medium text-gray-700 hover:text-black focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150';
                    } else {
                        $classes = '-ml-px relative inline-flex items-center px-4 py-2  bg-white text-xs leading-5 font-medium text-gray-700 hover:text-black focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150';
                    }
                @endphp

              <button type="button" @click="$el.style.width = '{{ $value }}'" class="{{ $classes }}">
                  {{ $label }}
              </button>
            @endforeach

        </div>

        <div class="border-dashed border-2 border-gray-600">
            {!! $body !!}
        </div>

    </div>

@endsection
