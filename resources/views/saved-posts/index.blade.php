<x-default-layout>
    <x-slot:title>
        {{ __('ui.saved_posts.index.title') }}
    </x-slot>

    <x-slot:description>
        {{ __('ui.saved_posts.index.description', ['app_name' => config('app.name')]) }}
    </x-slot>

    <h1 class="text-2xl font-bold dark:text-white">
        {{ __('ui.saved_posts.index.title') }}
    </h1>

    <p class="mt-4 dark:text-gray-300">
        {{ __('ui.saved_posts.index.description', ['app_name' => config('app.name')]) }}
    </p>

    <!-- J'ai utilisé Claude (web) pour m'aider à débugger car je fais la boucle sur des savedPosts, mais ça marchait pas pour utiliser le layout postcard.
     c'est pourquoi quand je mets $savedPost->post, ça va chercher le Post associé grâce à la relation post() que j'ai définie dans le modèle SavedPost -->
    <div class="mt-8 space-y-6">
        @forelse ($savedPosts as $savedPost)
            <div>
                <x-post-card :post="$savedPost->post" />
                <form method="POST" action="{{ url('/saved-posts/' . $savedPost->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-600 px-2 py-1 rounded-md">
                        🔖 Retirer
                    </button>
                </form>
            </div>

        @empty
            <p class="mt-4 dark:text-gray-300">{{ __('ui.saved_posts.index.empty') }}</p>
        @endforelse
    </div>
</x-default-layout>
