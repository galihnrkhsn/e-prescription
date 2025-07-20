<!DOCTYPE html>
<html>
<head>
    <title>Resep #{{ $resep->resep_id }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .title { font-size: 16px; font-weight: bold; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { padding: 6px; border: 1px solid #ccc; text-align: left; }
    </style>
</head>
<body>
    <div class="title">Resep #{{ $resep->resep_id }}</div>
    <p><strong>Nama Resep:</strong> {{ $resep->nama_resep }}</p>

    @if($resep->details)
        <h4>Obat Non Racikan</h4>
        <table>
            <thead>
                <tr>
                    <th>Obat</th>
                    <th>Qty</th>
                    <th>Signa</th>
                </tr>
            </thead>
            <tbody>
                @foreach($resep->details->whereNull('racikan_id') as $detail)
                <tr>
                    <td>{{ $detail->obatalkes->obatalkes_nama ?? '-' }}</td>
                    <td>{{ $detail->qty }}</td>
                    <td>{{ $detail->signa->signa_nama ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    @if($resep->racikans->count())
        <h4>Obat Racikan</h4>
        @foreach($resep->racikans as $racikan)
        <p><strong>{{ $racikan->nama_racikan }}</strong> ({{ $racikan->signa->signa_nama ?? '-' }})</p>
        <table>
            <thead>
                <tr>
                    <th>Obat</th>
                    <th>Qty</th>
                </tr>
            </thead>
            <tbody>
                @foreach($racikan->details as $item)
                <tr>
                    <td>{{ $item->obatalkes->obatalkes_nama ?? '-' }}</td>
                    <td>{{ $item->qty }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endforeach
    @endif
</body>
</html>
