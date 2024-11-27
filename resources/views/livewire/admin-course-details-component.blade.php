<div>
    <div class="container mx-auto p-6">
        <h2 class="text-2xl font-bold mb-4">{{ $courseDetails['course_name'] ?? 'Curso' }}</h2>

        <table class="table-auto w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-4 py-2 text-left">Usuario</th>
                    <th class="border px-4 py-2 text-left">Progreso</th>
                    <th class="border px-4 py-2 text-left">Video Actual</th>
                    <th class="border px-4 py-2 text-left">Progreso del Video</th>
                </tr>
            </thead>
            <tbody>
                @forelse($courseDetails['users'] as $user)
                    <tr>
                        <td class="border px-4 py-2">{{ $user['user_name'] }}</td>
                        <td class="border px-4 py-2">{{ $user['progress'] }}%</td>
                        <td class="border px-4 py-2">{{ $user['current_video']['title'] ?? 'N/A' }}</td>
                        <td class="border px-4 py-2">{{ $user['current_video']['progress'] ?? 0 }}%</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="border px-4 py-2 text-center">No hay usuarios registrados en este curso.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
