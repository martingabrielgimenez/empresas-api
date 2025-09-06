<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    const ESTADO_ACTIVO = 'Activo';
    const ESTADO_INACTIVO = 'Inactivo';

    protected $fillable = [
        'nit', 'nombre', 'direccion', 'telefono', 'estado'
    ];

    protected $casts = [
        'nit' => 'string',
        'nombre' => 'string',
        'direccion' => 'string',
        'telefono' => 'string',
        'estado' => 'string',
    ];

    // Scope para empresas inactivas
    public function scopeInactivas($query)
    {
        return $query->where('estado', self::ESTADO_INACTIVO);
    }
}
