<div>
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Videos del Curso</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @forelse ($videos as $video)

                <div class="bg-white shadow-md rounded p-4">
                    <h2 class="text-xl font-bold">{{ $video['title'] }}</h2>
                    <button
                        class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
                        style="	background-color: rgb(59 130 246);"
                        wire:click="goToVideo({{ $video['id'] }})"
                    >
                        Ver Video
                    </button>
                </div>
            @empty
                <p>No hay videos disponibles.</p>
            @endforelse
        </div>
    </div>

</div>
