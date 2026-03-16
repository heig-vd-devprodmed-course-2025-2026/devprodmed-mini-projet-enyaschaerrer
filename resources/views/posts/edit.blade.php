<x-default-layout>
    <x-slot:title>
        @if ($post->title)
            {{ __('ui.posts.edit.title', ['post_title' => $post->title]) }}
        @else
            {{ __('ui.posts.edit.title_without_post_title') }}
        @endif
    </x-slot>

    <x-slot:description>
        @if ($post->title)
            {{ __('ui.posts.edit.description', ['post_title' => $post->title]) }}
        @else
            {{ __('ui.posts.edit.description_without_post_title') }}
        @endif
    </x-slot>

    <h1 class="text-2xl font-bold dark:text-white">
        @if ($post->title)
            {{ __('ui.posts.edit.title', ['post_title' => $post->title]) }}
        @else
            {{ __('ui.posts.edit.title_without_post_title') }}
        @endif
    </h1>

    <p class="mt-4 dark:text-gray-300">
        @if ($post->title)
            {{ __('ui.posts.edit.description', ['post_title' => $post->title]) }}
        @else
            {{ __('ui.posts.edit.description_without_post_title') }}
        @endif
    </p>

    {{-- Formulaire à venir... --}}
</x-default-layout>