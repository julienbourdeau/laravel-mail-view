@extends('mail-view::base')

@section('content')

    <h1 class="text-4xl font-bold mb-12">Mail View</h1>

    @forelse($mailViewCollection as $className => $methods)
        <h2 class="text-2xl mb-6">{{ Str::beforeLast($className, 'Preview') }}</h2>

{{--        <ul class="pl-6 list-disc text-blue-800 space-y-2">--}}
{{--            @forelse ($methods as $attributes)--}}
{{--                <li>--}}
{{--                    <a class="hover:text-blue-600 text-lg" href="{{ route('mail-view.show', [$className, $attributes['methodName']]) }}">--}}
{{--                        {{ $attributes['methodName'] }}--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--            @empty--}}
{{--                <li>No method found in {{ $className }}</li>--}}
{{--            @endforelse--}}
{{--        </ul>--}}

        <div class="bg-white rounded shadow overflow-x-auto max-w-6xl">
            <table class="w-full whitespace-no-wrap">
                <tr class="text-left font-bold">
                    <th class="p-6 w-12">#</th>
                    <th class="px-6 pt-6 pb-4">Preview</th>
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
                                    <strong>{{ $attributes['methodName'] }}</strong>
                                    <small>{{ $attributes['comment'] }}</small>
                                </div>
                            </a>
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
