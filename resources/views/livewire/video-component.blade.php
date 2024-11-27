
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6  bg-gray-100 min-h-screen">
                <h1 class="text-2xl font-bold text-gray-800 mb-6">Videos</h1>

                <!-- Create/Edit Form -->
                <div class="bg-white shadow-md rounded-lg p-6 mb-8">
                    <form wire:submit.prevent="{{ $isEdit ? 'updateVideo' : 'createVideo' }}">
                        <div class="grid grid-cols-2 gap-6 mb-4">
                            <div>
                                <label for="title" class="block text-gray-700 font-medium mb-2">Titulo</label>
                                <input
                                    type="text"
                                    id="title"
                                    wire:model="title"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                >
                                @error('title')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label for="url" class="block text-gray-700 font-medium mb-2">Url</label>
                                <input
                                    type="text"
                                    id="url"
                                    wire:model="url"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                >
                                @error('url')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label for="categories" class="block text-sm font-medium text-gray-700 ">Categorias</label>
                                <select name="" id="categories" wire:model="selectedCategories" multiple class="mt-1 block w-full rounded-md shadow-sm border-gray-300">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                                    @endforeach
                                </select>
                                @error('selectedCategories') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="flex space-x-4">
                            <button
                                type="submit"
                               style="background-color: rgb(107 114 128)"
                                class="text-white  px-4 py-2 rounded-lg hover:bg-blue-600 transition"
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

                <!-- Video List -->
                <div class="bg-white shadow-md rounded-lg p-6">
                    <table class="w-full table-auto border-collapse">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="text-left px-4 py-2">ID</th>
                                <th class="text-left px-4 py-2">Titulo</th>
                                <th class="text-left px-4 py-2">Url</th>
                                <th class="text-left px-4 py-2">Actiones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($videos as $video)
                                <tr class="border-b">
                                    <td class="px-4 py-2">{{ $video['id'] }}</td>
                                    <td class="px-4 py-2">{{ $video['title'] }}</td>
                                    <td class="px-4 py-2">{{ $video['url'] }}</td>
                                    <td class="px-4 py-2 space-x-2">
                                        <button
                                            wire:click="editVideo({{ $video['id'] }})"
                                            class="  px-3 py-1 rounded-lg hover:bg-yellow-600 transition"
                                             style="background-color: rgb(16 185 129);"
                                        >
                                            Editar
                                        </button>
                                        <button
                                            wire:click="goToStats({{ $video['id'] }})"
                                            class=" text-white px-3 py-1 rounded-lg transition"
                                            style="background-color: rgb(16 185 129);"
                                        >
                                                Estadisticas
                                        </button>
                                        <button
                                            wire:click="confirmDeleteVideo({{ $video['id'] }})"
                                              style="background-color: rgb(239 68 68);"
                                            class=" px-3 py-1 rounded-lg hover:bg-red-600 transition"
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
                        if (confirm('Quieres eliminar el video?')) {
                            Livewire.dispatch('deleteVideo', {id:event.detail.id});
                        }
                    });
                </script>
            </div>
        </div>
    </div>
</div>

