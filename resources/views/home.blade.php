<x-default-layout>
    <x-slot:title>
        {{ __('ui.home.title') }}
    </x-slot>

    <x-slot:description>
        {{ __('ui.home.description') }}
    </x-slot>

    <h1 class="text-2xl font-bold dark:text-white">
        {{ config('app.name') }}
    </h1>

    <p class="mt-4 dark:text-gray-300">
        {{ __('ui.home.introduction', ['app_name' => config('app.name')]) }}
    </p>

    <div class="mt-8 space-y-6">
        @foreach ($posts as $post)
            <article>
                <h3>{{ $post->user->first_name }} {{ $post->user->last_name }} ({{ $post->created_at }})</h3>

                @if ($post->title)
                    <h2>{{ $post->title }}</h2>
                @endif

                <p>{{ $post->content }}</p>

                <p>{{ trans_choice('ui.posts.likes_count', count($post->likes)) }}</p>
            </article>
        @endforeach
    </div>
</x-default-layout>