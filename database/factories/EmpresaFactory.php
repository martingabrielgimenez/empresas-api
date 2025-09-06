<?php

namespace Database\Factories;

use App\Models\Empresa;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmpresaFactory extends Factory
{
    protected $model = Empresa::class;

    public function definition(): array
    {
        return [
            'nit' => $this->faker->unique()->numerify('#########'),
            'nombre' => $this->faker->company,
            'direccion' => $this->faker->address,
            'telefono' => $this->faker->phoneNumber,
            'estado' => $this->faker->randomElement([
                Empresa::ESTADO_ACTIVO,
                Empresa::ESTADO_INACTIVO
            ]),
        ];
    }
}
