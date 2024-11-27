<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6  bg-gray-100 min-h-screen">
                <h1 class="text-2xl font-bold mb-4">Gestión de Roles</h1>
                <div class="grid grid-cols-2 gap-6 mb-4">
                    <div>
                        <label for="roleName" class="block text-gray-700 font-medium mb-2">Nombre del Rol</label>
                        <input type="text" wire:model="roleName" id="roleName"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>
                </div>
                <button wire:click="createRole"
                    class="mt-2 px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                    Crear Rol
                </button>

                <div class="p-6 bg-gray-100">

                    <!-- Lista de Roles -->
                    <h2 class="text-xl font-semibold mb-2">Lista de Roles</h2>
                    <ul class="mb-4">
                        @foreach($roles as $role)
                            <li class="py-2 border-b">{{ $role['name'] }}</li>
                        @endforeach
                    </ul>

                    <!-- Asignar Roles -->
                    <h2 class="text-xl font-semibold mb-2">Asignar Roles a Usuarios</h2>
                    <table class="table-auto w-full bg-white shadow rounded">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="px-4 py-2">Usuario</th>
                                <th class="px-4 py-2">Rol</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td class="px-4 py-2">{{ $user['name'] }}</td>
                                    <td class="px-4 py-2">
                                        <select wire:change="assignRole({{ $user['id'] }}, $event.target.value)"
                                            class="block w-full rounded border-gray-300">
                                            <option value="">Selecciona un rol</option>
                                            @foreach($roles as $role)
                                                <option value="{{ $role['id'] }}">{{ $role['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Mensajes -->
                    @if (session()->has('message'))
                        <div class="mt-4 p-4 bg-green-100 text-green-700 rounded">
                            {{ session('message') }}
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>

</div>
