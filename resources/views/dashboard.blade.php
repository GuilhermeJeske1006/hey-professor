<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <x-container>
        <x-form method="POST" :action="route('question.store')">
            <div class="mb-4">
                <x-textarea label="Sua Pergunta" name="question"/>
            </div>
            <x-btn.primary type="submit">Save</x-btn.primary>
            <x-btn.reset type="reset">Cancel</x-btn.reset>
    </x-form>
    </x-container>
        
</x-app-layout>
