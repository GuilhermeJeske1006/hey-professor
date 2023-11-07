<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Votar as perguntas') }}
        </h2>
    </x-slot>

    <x-container>


    <div class="dark:text-gray-400 space-y-4">
        @foreach ($questions as $item)
            <x-question :question="$item"></x-question>
        @endforeach
    </div>
    </x-container>
        
</x-app-layout>
