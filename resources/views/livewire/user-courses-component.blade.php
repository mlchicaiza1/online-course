<div>
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Mis Cursos</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @forelse ($courses as $course)
                <div class="bg-white shadow-md rounded p-4">
                    <h2 class="text-xl font-bold">{{ $course['name'] }}</h2>
                    <p class="text-gray-600">{{ $course['description'] }}</p>
                    <p class="text-gray-600">Progreso: {{ $course['users'][0]['progress']}} %</p>
                    <button
                        class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
                        style="	background-color: rgb(59 130 246);"
                        wire:click="goToVideos({{ $course['id'] }})"
                    >
                        Ver Videos
                    </button>
                </div>
            @empty
                <p>No estás inscrito en ningún curso.</p>
            @endforelse
        </div>
    </div>
</div>
