<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Statistiques -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4 text-gray-800 dark:text-white">📊 Statistiques générales</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div>
                        <canvas id="tachesStatutChart"></canvas>
                    </div>
                    <div>
                        <canvas id="usersDepartementChart"></canvas>
                    </div>
                    <div>
                        <canvas id="tachesParMoisChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Graphique 1: Statut des tâches
        const tachesStatutChart = new Chart(document.getElementById('tachesStatutChart'), {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($statutsLabels) !!},
                datasets: [{
                    data: {!! json_encode($statutsCounts) !!},
                    backgroundColor: ['#10B981', '#F59E0B', '#EF4444'],
                }]
            }
        });

        // Graphique 2: Utilisateurs par département
        const usersDepartementChart = new Chart(document.getElementById('usersDepartementChart'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($departementsLabels) !!},
                datasets: [{
                    label: 'Utilisateurs',
                    data: {!! json_encode($departementsCounts) !!},
                    backgroundColor: '#3B82F6'
                }]
            }
        });

        // Graphique 3: Tâches par mois
        const tachesParMoisChart = new Chart(document.getElementById('tachesParMoisChart'), {
            type: 'line',
            data: {
                labels: {!! json_encode($moisLabels) !!},
                datasets: [{
                    label: 'Tâches créées',
                    data: {!! json_encode($moisCounts) !!},
                    borderColor: '#8B5CF6',
                    fill: false
                }]
            }
        });
    </script>
</x-app-layout>
