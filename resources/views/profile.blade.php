<x-default-layout>
    <x-slot:title>
        {{ __('ui.profile.title', ['username' => $user->username]) }}
    </x-slot>

    <x-slot:description>
        {{ __('ui.profile.description', ['username' => $user->username]) }}
    </x-slot>

    <h1 class="text-2xl font-bold dark:text-white">
        {{ __('ui.profile.title', ['username' => $user->username]) }}
    </h1>

    <p class="mt-4 dark:text-gray-300">
        {{ trans_choice('ui.profile.number_of_posts', count($posts)) }}
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