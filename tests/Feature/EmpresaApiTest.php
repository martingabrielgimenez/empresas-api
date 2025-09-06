<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Empresa;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmpresaApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function puede_crear_empresa()
    {
        $response = $this->postJson('/api/empresas', [
            'nit' => '123456789',
            'nombre' => 'Aicoll Tech',
            'direccion' => 'Calle 123',
            'telefono' => '3001234567',
        ]);

        $response->assertStatus(201)
                 ->assertJsonPath('success', true)
                 ->assertJsonPath('data.nit', '123456789');

        $this->assertDatabaseHas('empresas', [
            'nit' => '123456789',
            'estado' => Empresa::ESTADO_ACTIVO
        ]);
    }

    /** @test */
    public function no_puede_crear_empresa_con_nit_duplicado()
    {
        Empresa::factory()->create(['nit' => '123456789']);

        $response = $this->postJson('/api/empresas', [
            'nit' => '123456789',
            'nombre' => 'Otra Empresa'
        ]);

        $response->assertStatus(422);
    }

    /** @test */
    public function puede_actualizar_empresa()
    {
        Empresa::factory()->create([
            'nit' => '987654321',
            'nombre' => 'Empresa Vieja'
        ]);

        $response = $this->putJson('/api/empresas/987654321', [
            'nombre' => 'Empresa Nueva',
            'estado' => Empresa::ESTADO_INACTIVO
        ]);

        $response->assertStatus(200)
                 ->assertJsonPath('data.nombre', 'Empresa Nueva')
                 ->assertJsonPath('data.estado', Empresa::ESTADO_INACTIVO);
    }

    /**Test */
    public function solo_elimina_si_esta_inactiva()
    {
        $empresa = Empresa::factory()->create([
            'nit' => '000111222',
            'estado' => Empresa::ESTADO_ACTIVO
        ]);

        // Intento eliminar activa
        $response = $this->deleteJson('/api/empresas/000111222');
        $response->assertStatus(400);

        // Cambiamos a inactiva
        $empresa->update(['estado' => Empresa::ESTADO_INACTIVO]);

        $response = $this->deleteJson('/api/empresas/000111222');
        $response->assertStatus(200);

        $this->assertDatabaseMissing('empresas', ['nit' => '000111222']);
    }

    /** @test */
    public function puede_eliminar_todas_las_inactivas()
    {
        Empresa::factory()->count(2)->create(['estado' => Empresa::ESTADO_INACTIVO]);
        Empresa::factory()->create(['estado' => Empresa::ESTADO_ACTIVO]);

        $response = $this->deleteJson('/api/empresas/inactivas');

        $response->assertStatus(200)
                 ->assertJsonFragment(['success' => true]);

        $this->assertDatabaseCount('empresas', 1);
    }
}
