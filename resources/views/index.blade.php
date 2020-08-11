@extends('mail-view::base')

@section('content')

    <div class="flex justify-between max-w-6xl">
        <h1 class="text-4xl font-bold mb-12">Mail View</h1>
        <div id="page-actions">
            <a href="{{ route('mail-view.send-all') }}" class="block mt-1 py-2 px-3 bg-white text-gray-700 uppercase text-sm font-semibold shadow rounded border hover:border-gray-700">Send all</a>
        </div>
    </div>

    @if (session('status'))
        <div class="bg-white p-6 border-2 border-green-600 text-green-700 font-bold mb-12 rounded shadow overflow-x-auto max-w-6xl">
            {{ session('status') }}
        </div>
    @endif

    @forelse($mailViewCollection as $className => $methods)
        <h2 class="text-2xl mb-6">{{ Str::beforeLast($className, 'Preview') }}</h2>

        <div class="bg-white mb-12 rounded shadow overflow-x-auto max-w-6xl">
            <table class="w-full whitespace-no-wrap">
                <tr class="text-left font-bold">
                    <th class="p-6 w-12">#</th>
                    <th class="px-6 pt-6 pb-4">Preview</th>
                    <th class="p-6 w-12">&nbsp;</th>
                </tr>
                @forelse($methods as $attributes)
                    <tr class="hover:bg-grey-lightest focus-within:bg-grey-lightest">
                        <td class="border-t">
                            <div class="px-6 py-4 flex items-center focus:text-indigo">
                                {{ $loop->index + 1 }}
                            </div>
                        </td>
                        <td class="border-t">
                            <a href="{{ route('mail-view.show', [$className, $attributes['methodName']]) }}">
                                <div class="px-6 py-4 flex flex-col leading-relaxed outline-0" tabindex="-1">
                                    <strong>{{ \Illuminate\Support\Str::studly($attributes['methodName']) }}</strong>
                                    <small>{{ $attributes['comment'] }}</small>
                                </div>
                            </a>
                        </td>
                        <td class="border-t">
                            <div class="px-6 py-4 flex items-center focus:text-indigo">
                                <a href="{{ route('mail-view.send', [$className, $attributes['methodName']]) }}" class="py-2 px-3 text-gray-700 uppercase text-sm font-semibold  hover:text-gray-900">Send</a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="border-t py-12 text-center" colspan="5">No preview found.</td>
                    </tr>
                @endforelse
            </table>
        </div>

    @empty
        No MailView class found. Create your first one is `tests/MailView` folder,
    @endforelse


@endsection
