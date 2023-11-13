<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Minhas perguntas') }}
        </h2>
    </x-slot>

    <x-container>
        <x-form  :action="route('question.store')">
            <div class="mb-4">
                <x-textarea label="Sua Pergunta" name="question" />
            </div>
            <x-btn.primary type="submit">Save</x-btn.primary>
            <x-btn.reset type="reset">Cancel</x-btn.reset>
        </x-form>

        <hr class="border-gray-700 border-dashed my-4">

        <div class="dark:text-gray-400 uppercase font-bold mb-1">Meus rascunhos</div>

        <div class="dark:text-gray-400 space-y-4">


            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

                <x-table>
                    <x-table.thead>
                        <tr>
                            <x-table.th>Perguntas</x-table.th>
                            <x-table.th>Ações</x-table.th>

                        </tr>
                    </x-table.thead>
                    <tbody>
                        @foreach ($questions->where('draft', true) as $question)
                            <x-table.tr>
                                <x-table.td>{{ $question->question }}</x-table.td>
                                <x-table.td>
                                    <x-form :action="route('question.destroy', $question)" delete>
                                        <button class="houver:underline text-blue-500">
                                             Deletar
                                         </button> 
                                     </x-form>
                                     
                                    <x-form :action="route('question.publish', $question)" put>
                                       <button class="houver:underline text-blue-500">
                                            Publicar
                                        </button> 
                                    </x-form>

                                    <a href="{{ route('question.edit', $question) }}" class="houver:underline text-blue-500">Editar</a>
                                </x-table.td>

                            </x-table.tr>
                        @endforeach

                    </tbody>
                </x-table>

            </div>

            <hr class="border-gray-700 border-dashed my-4">

            <div class="dark:text-gray-400 uppercase font-bold mb-1">Minhas de perguntas</div>

            <div class="dark:text-gray-400 space-y-4">


                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

                    <x-table>
                        <x-table.thead>
                            <tr>
                                <x-table.th>Perguntas</x-table.th>
                                <x-table.th>Ações</x-table.th>

                            </tr>
                        </x-table.thead>
                        <tbody>
                            @foreach ($questions->where('draft', false) as $question)
                                <x-table.tr>
                                    <x-table.td>{{ $question->question }}</x-table.td>
                                    <x-table.td>
                                        <x-form :action="route('question.destroy', $question)" delete>
                                            <button class="houver:underline text-blue-500">
                                                 Deletar
                                             </button> 
                                         </x-form>
                                    </x-table.td>

                                </x-table.tr>
                            @endforeach

                        </tbody>
                    </x-table>

                </div>

            </div>
    </x-container>

</x-app-layout>
