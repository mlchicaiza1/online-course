
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6  bg-gray-100 min-h-screen">
                <h1 class="text-2xl font-bold text-gray-800 mb-6">Coursos</h1>

                <!-- Create/Edit Form -->
                <div class="bg-white shadow-md rounded-lg p-6 mb-8">
                    <form wire:submit.prevent="{{ $isEdit ? 'updateCourse' : 'createCourse' }}">
                        <div class="grid grid-cols-2 gap-6 mb-4">
                            <div>
                                <label for="name" class="block text-gray-700 font-medium mb-2">Nombre</label>
                                <input
                                    type="text"
                                    id="name"
                                    wire:model="name"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                >
                                @error('name')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label for="description" class="block text-gray-700 font-medium mb-2">Descripción</label>
                                <input
                                    type="text"
                                    id="description"
                                    wire:model="description"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                >
                                @error('description')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label for="age_min" class="block text-gray-700 font-medium mb-2">Edad Min</label>
                                <input
                                    type="number"
                                    id="age_min"
                                    wire:model="age_min"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                >
                                @error('age_min')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label for="age_max" class="block text-gray-700 font-medium mb-2">Edad Max</label>
                                <input
                                    type="number"
                                    id="age_max"
                                    wire:model="age_max"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                >
                                @error('age_max')
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
                                class="px-4 py-2  rounded-lg text-white  hover:bg-blue-600 transition"
                                style="background-color: rgb(107 114 128)"
                            >
                                {{ $isEdit ? 'Actualizar' : 'Crear' }}
                            </button>
                            @if ($isEdit)
                                <button
                                    type="button"
                                    wire:click="resetForm"
                                    class="bg-red-950 px-4 mr-4 py-2 text-white rounded-lg hover:bg-gray-600 transition"
                                    style="background-color: rgb(107 114 128)"
                                >
                                    Cancel
                                </button>
                            @endif
                        </div>
                    </form>
                </div>

                <!-- Course List -->
                <div class="bg-white shadow-md rounded-lg p-6">
                    <table class="w-full table-auto border-collapse">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="text-left px-4 py-2">ID</th>
                                <th class="text-left px-4 py-2">Nombre</th>
                                <th class="text-left px-4 py-2">Descripción</th>
                                <th class="text-left px-4 py-2">Edad Min</th>
                                <th class="text-left px-4 py-2">Edad Max</th>
                                <th class="text-left px-4 py-2">Actiones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($courses as $course)
                                <tr class="border-b">
                                    <td class="px-4 py-2">{{ $course['id'] }}</td>
                                    <td class="px-4 py-2">{{ $course['name'] }}</td>
                                    <td class="px-4 py-2">{{ $course['description'] }}</td>
                                    <td class="px-4 py-2">{{ $course['age_min'] }}</td>
                                    <td class="px-4 py-2">{{ $course['age_max'] }}</td>
                                    <td class="px-4 py-2 space-x-2">
                                        <button
                                            wire:click="editCourse({{ $course['id'] }})"
                                            class=" text-white  px-3 py-1 rounded-lg hover:bg-yellow-600 transition"
                                             style="background-color: rgb(16 185 129);"
                                        >
                                            Editar
                                        </button>
                                        <button
                                            wire:click="goToVideos({{ $course['id'] }})"
                                            class=" text-white px-3 py-1 rounded-lg transition"
                                            style="background-color: rgb(16 185 129);"
                                        >
                                            Agregar Videos
                                    </button>
                                        <button
                                            wire:click="confirmDeleteCourse({{ $course['id'] }})"
                                            class="px-3 py-1 text-white rounded-lg hover:bg-red-600 transition"
                                            style="background-color: rgb(239 68 68); "
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
                        if (confirm('Quieres eliminar el Curso?')) {
                            Livewire.dispatch('deleteCourse', {id:event.detail.id});
                        }
                    });
                </script>
            </div>
        </div>
    </div>
</div>

