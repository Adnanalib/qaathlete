<div class="w-full mt-6 pl-f-0 dashboard-navbar">
    <div>
        <canvas id="myChart" style="max-height: 370px; width: 100%;"></canvas>
    </div>
</div>
<div class="w-full mt-6 dashboard-navbar">
    <div class="mt-5">
        <table class="table qr-chart-table">
            <thead>
                <tr>
                    <th scope="col">Scan Device</th>
                    <th scope="col">Location</th>
                    <th scope="col">City</th>
                    <th scope="col">Scan Count</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($chartDetail['data'] as $device)
                    <tr>
                        <td scope="row">{{ $device['_id']['device'] ?? '-' }}</td>
                        <td scope="row">{{ $device['_id']['loc'] ?? '-' }}</td>
                        <td scope="row">{{ $device['_id']['city'] ?? '-' }}</td>
                        <td>{{ $device['count'] ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('assets/js/qr-chart.js') }}"></script>
<script>
    loadQrChartData(@json($chartDetail['graph']['labels']), @json($chartDetail['graph']['scans']));
</script>
