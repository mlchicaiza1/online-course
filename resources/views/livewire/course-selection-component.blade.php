<div class="py-12">
    <h1 class="text-xl font-bold mx-5 mb-4">Buscar Cursos</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mx-5">
        <input
            type="text"
            wire:model="name"
            placeholder="Nombre del curso"
            class="border border-gray-300 rounded-lg px-4 py-2 w-full sm:w-auto flex-grow"
        >
        <input
            type="number"
            wire:model="age_min"
            placeholder="Edad mínima"
            class="border border-gray-300 rounded-lg px-4 py-2 w-full sm:w-auto flex-grow"
        >
        <input
            type="number"
            wire:model="age_max"
            placeholder="Edad máxima"
            class="border border-gray-300 rounded-lg px-4 py-2 w-full sm:w-auto flex-grow"
        >
        <select
            wire:model="category_id"
            class="border border-gray-300 rounded-lg px-4 py-2 w-full sm:w-auto flex-grow">
            <option value="">Seleccione una categoría</option>
            @foreach ($categories as $category)
                <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
            @endforeach
        </select>
    </div>
    <button
        wire:click="search"
        class="bg-blue-500 text-white px-4 py-2 rounded-lg mt-4 mb-4 mx-5 "
        style="background-color: rgb(59 130 246);"
    >

        Buscar
    </button>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mx-5">
        @foreach ($courses as $course)
            @php
                $isEnrolled = in_array($course['id'], $userCourseIds); // Lista de IDs de cursos registrados
            @endphp
            <div class="border rounded-lg p-4 shadow hover:shadow-lg transition bg-white">
                <h2 class="text-xl font-bold mb-2">{{ $course['name'] }}</h2>
                <p class="text-gray-700 mb-4">{{ $course['description'] }}</p>
                <button
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition"
                    style="	background-color: rgb(59 130 246);"
                    wire:click="selectCourse({{ $course['id'] }})"
                    @if ($isEnrolled) disabled class="bg-gray-400 cursor-not-allowed" @endif
                >
                    {{ $isEnrolled ? 'Ya registrado' : 'Seleccionar Curso' }}
                </button>
                @role('admin')
                    <button
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition"
                        style="	background-color: rgb(59 130 246);"
                        wire:click="adminCourse({{ $course['id'] }})"
                    >
                        Administrar Curso
                    </button>
                @endrole

            </div>
        @endforeach
    </div>

</div>
<script>
    window.addEventListener('course-selected', event => {
        alert(event.detail[0].message);
    });
</script>
