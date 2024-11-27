<div class="container mx-auto p-6">
    <!-- Mostrar video -->
    <h2 class="text-xl font-bold mb-4">{{ $video['title'] }}</h2>
    <iframe src="{{ str_replace('watch?v=', 'embed/', $video['url']) }}" frameborder="0" class="w-full h-full" allowfullscreen></iframe>
    <button
        wire:click="VideoCompleted"
        class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition mt-5"
        style="	background-color: rgb(59 130 246);"
        @if($progress == 100) disabled @endif
    >
        {{ $progress == 100 ? 'Completado' : 'Marcar como Completado' }}
    </button>
    <button
        wire:click="toggleLike"
        class="{{ $isLiked? 'bg-red-500 hover:bg-red-600' : 'bg-gray-500 hover:bg-gray-600' }} text-sky-500 px-4 py-2 rounded transition"
    >
        {{ $isLiked ? 'Quitar Like' : 'Dar Like' }}
    </button>
    <!-- Lista de comentarios -->
    <div class="mt-6">
        <h3 class="text-lg font-bold mb-2">Comentarios</h3>
        <ul class="space-y-3">
            @foreach ($comments as $comment)
                @if ($comment['state']=='aprobado')
                    <li class="p-3 border rounded" >
                        <strong>{{ $comment['user']['name'] ?? 'Usuario' }}</strong>:
                        <p>{{ $comment['comment'] }}</p>
                    </li>
                @endif

            @endforeach
        </ul>
    </div>

    <!-- Agregar un nuevo comentario -->
    <div class="mt-6">
        <textarea
            wire:model="commentContent"
            class="w-full border rounded p-2 mb-2"
            placeholder="Escribe tu comentario aquí..."></textarea>
        <button
            wire:click="addComment"
            style="	background-color: rgb(59 130 246);"
            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
            Agregar Comentario
        </button>
    </div>
</div>
