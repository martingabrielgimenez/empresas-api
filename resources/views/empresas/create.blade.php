@extends('layout')

@section('content')
    <h1>Nueva Empresa</h1>

    <form action="{{ route('empresas.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">NIT</label>
            <input type="text" name="nit" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Dirección</label>
            <input type="text" name="direccion" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Teléfono</label>
            <input type="text" name="telefono" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Estado</label>
            <select name="estado" class="form-select">
                <option value="Activo">Activo</option>
                <option value="Inactivo">Inactivo</option>
            </select>
        </div>
        <button class="btn btn-success">💾 Guardar</button>
        <a href="{{ route('empresas.index') }}" class="btn btn-secondary">⬅️ Volver</a>
    </form>
@endsection
