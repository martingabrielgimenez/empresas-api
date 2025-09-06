<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Empresa;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmpresaModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function puede_filtrar_empresas_inactivas()
    {
        // Creamos empresas activas e inactivas
        Empresa::factory()->create(['estado' => Empresa::ESTADO_ACTIVO]);
        Empresa::factory()->create(['estado' => Empresa::ESTADO_INACTIVO]);
        Empresa::factory()->create(['estado' => Empresa::ESTADO_INACTIVO]);

        $inactivas = Empresa::inactivas()->get();

        $this->assertCount(2, $inactivas);
        $this->assertEquals(Empresa::ESTADO_INACTIVO, $inactivas->first()->estado);
    }
}
