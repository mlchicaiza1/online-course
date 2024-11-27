<div>
    <div class="container mx-auto p-6">
        <h2 class="text-2xl font-bold mb-4">Estadísticas del Video</h2>
        <table class="table-auto w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border px-4 py-2">ID del Video</th>
                    <th class="border px-4 py-2">Vistas</th>
                    <th class="border px-4 py-2">Progreso Promedio</th>
                    <th class="border px-4 py-2">Likes</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border px-4 py-2">{{ $videoId }}</td>
                    <td class="border px-4 py-2">{{ $statistics['views'] }}</td>
                    <td class="border px-4 py-2">{{ number_format($statistics['average_progress'], 2) }}%</td>
                    <td class="border px-4 py-2">{{ $statistics['likes'] }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
