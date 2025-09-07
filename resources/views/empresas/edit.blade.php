@extends('layout')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Editar Empresa</h1>

    <form action="{{ route('empresas.updateWeb', $empresa->nit) }}" method="POST" class="card p-4 shadow-sm">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nit" class="form-label">NIT</label>
            <input type="text" class="form-control" id="nit" name="nit" value="{{ $empresa->nit }}" readonly>
        </div>

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $empresa->nombre }}" required>
        </div>

        <div class="mb-3">
            <label for="direccion" class="form-label">Dirección</label>
            <input type="text" class="form-control" id="direccion" name="direccion" value="{{ $empresa->direccion }}">
        </div>

        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" class="form-control" id="telefono" name="telefono" value="{{ $empresa->telefono }}">
        </div>

        <div class="mb-3">
            <label for="estado" class="form-label">Estado</label>
            <select class="form-select" id="estado" name="estado">
                <option value="Activo" {{ $empresa->estado == 'Activo' ? 'selected' : '' }}>Activo</option>
                <option value="Inactivo" {{ $empresa->estado == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
            </select>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success">
            💾 Actualizar
            </button>
            <a href="{{ route('empresas.indexWeb') }}" class="btn btn-secondary">
            ⬅️ Volver
            </a>
        </div>

    </form>
</div>
@endsection
