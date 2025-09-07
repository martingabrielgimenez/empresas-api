<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Empresas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
    <h1 class="mb-4">Empresas</h1>

    <a href="{{ route('empresas.create') }}" class="btn btn-primary mb-3">➕ Nueva Empresa</a>
    <button class="btn btn-danger mb-3" onclick="eliminarInactivas()">🗑️ Eliminar Inactivas</button>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>NIT</th><th>Nombre</th><th>Dirección</th><th>Teléfono</th><th>Estado</th><th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        @forelse($empresas as $e)
            <tr>
                <td>{{ $e->nit }}</td>
                <td>{{ $e->nombre }}</td>
                <td>{{ $e->direccion }}</td>
                <td>{{ $e->telefono }}</td>
                <td>{{ $e->estado }}</td>
                <td>
                    <a href="{{ route('empresas.edit', $e->nit) }}" class="btn btn-sm btn-warning">✏️ Editar</a>
                    <button class="btn btn-sm btn-danger" onclick="eliminarUno('{{ $e->nit }}')">🗑️ Eliminar</button>
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="text-center">No hay empresas</td></tr>
        @endforelse
        </tbody>
    </table>
</div>

<script>
async function eliminarInactivas() {
    if (!confirm('¿Eliminar todas las empresas inactivas?')) return;
    const r = await fetch('/api/empresas/inactivas', { method: 'DELETE', headers: { 'Accept': 'application/json' }});
    alert(r.ok ? 'Eliminadas' : 'Error al eliminar');
    location.reload();
}

async function eliminarUno(nit) {
    if (!confirm('¿Eliminar esta empresa? (Debe estar Inactiva)')) return;
    const r = await fetch('/api/empresas/' + nit, { method: 'DELETE', headers: { 'Accept': 'application/json' }});
    const j = await r.json().catch(()=>({}));
    if (r.ok) { alert('Eliminada'); location.reload(); }
    else { alert(j.message ?? 'No se pudo eliminar'); }
}
</script>
</body>
</html>
