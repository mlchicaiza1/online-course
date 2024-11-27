<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6  bg-gray-100 min-h-screen">
                <h1 class="text-2xl font-bold text-gray-800 mb-6">Comentarios</h1>

                <!-- Create/Edit Form -->
                <div class="bg-white shadow-md rounded-lg p-6 mb-8">
                    <form wire:submit.prevent="{{ $isEdit ? 'updateComment' : 'createComment' }}">
                        <div class="grid grid-cols-2 gap-6 mb-4">
                            <div>
                                <label for="comment" class="block text-gray-700 font-medium mb-2">Comentario</label>
                                <input
                                    type="text"
                                    id="comment"
                                    wire:model="comment"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                >
                                @error('comment')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label for="state" class="block text-gray-700 font-medium mb-2">Estado</label>
                                <select
                                    id="state"
                                    wire:model="state"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                >
                                    <option value="">Seleccione un estado</option>
                                    <option value="aprobado">aprobado</option>
                                    <option value="pendiente">pendiente</option>
                                    <option value="denegado">rechazado</option>
                                </select>
                                @error('state')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>

                        <div class="flex space-x-4">
                            <button
                                type="submit"
                                style="background-color: rgb(107 114 128)"
                                class="text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition"
                            >
                                {{ $isEdit ? 'Actualizar' : 'Crear' }}
                            </button>
                            @if ($isEdit)
                                <button
                                    type="button"
                                    wire:click="resetForm"
                                    class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition"
                                >
                                    Cancelar
                                </button>
                            @endif
                        </div>
                    </form>
                </div>

                <!-- Comment List -->
                <div class="bg-white shadow-md rounded-lg p-6">
                    <table class="w-full table-auto border-collapse">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="text-left px-4 py-2">ID</th>
                                <th class="text-left px-4 py-2">Comentario</th>
                                <th class="text-left px-4 py-2">Estado</th>
                                <th class="text-left px-4 py-2">Video</th>
                                <th class="text-left px-4 py-2">Actiones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($comments as $comment)
                                <tr class="border-b">
                                    <td class="px-4 py-2">{{ $comment['id'] }}</td>
                                    <td class="px-4 py-2">{{ $comment['comment'] }}</td>
                                    <td class="px-4 py-2">{{ $comment['state'] }}</td>
                                    <td class="px-4 py-2">{{ $comment['video']['title'] }}</td>
                                    <td class="px-4 py-2 space-x-2">
                                        <button
                                            style="background-color: rgb(16 185 129);"
                                            wire:click="editComment({{ $comment['id'] }})"
                                            class="  px-3 py-1 rounded-lg hover:bg-yellow-600 transition"
                                        >
                                            Editar
                                        </button>
                                        <button
                                            style="background-color: rgb(239 68 68); "
                                            wire:click="confirmDeleteComment({{ $comment['id'] }})"
                                            class="bg-red-500  px-3 py-1 rounded-lg hover:bg-red-600 transition"
                                        >
                                            Eliminar
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- JavaScript Confirmation -->
                <script>
                    window.addEventListener('confirmDelete', event => {
                        if (confirm('Are you sure you want to delete this comment?')) {
                            Livewire.dispatch('deleteComment', {id:event.detail.id});
                        }
                    });
                </script>
            </div>
        </div>
    </div>
</div>
