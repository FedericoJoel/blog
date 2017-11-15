<?php

use App\Repositories\Eloquent\Contabilidad\GeneradorDeCuentas;
use App\Repositories\Eloquent\Repos\Gateway\ImputacionGateway;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InicioSistema extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function(){
            $mock = Mockery::mock('overload:App\Repositories\Eloquent\ControlFechaContable');
            $fecha = \Carbon\Carbon::today();
            $mock->shouldReceive('getFechaContable')->andReturn($fecha);
            $ejercicio = factory(\App\Ejercicio::class)->create();

            $proveedores = \App\Proovedores::all();

            // Capitulos
            $capituloResultado = factory(\App\Capitulo::class)->create(['nombre' => 'Resultado', 'codigo' => 5]);
            $capituloActivo = factory(\App\Capitulo::class)->create(['nombre' => 'Activo', 'codigo' => 1]);
            $capituloPasivo = factory(\App\Capitulo::class)->create(['nombre' => 'Pasivo', 'codigo' => 3]);


            // Rubro
            $rubroCajaYBanco = factory(\App\Rubro::class)->create(['id_capitulo' => $capituloActivo->id, 'nombre' => 'Caja y bancos', 'codigo' => 11]);
            $rubroCreditos = factory(\App\Rubro::class)->create(['id_capitulo' => $capituloActivo->id, 'nombre' => 'Creditos', 'codigo' => 13]);
            $rubroDeudas = factory(\App\Rubro::class)->create(['id_capitulo' => $capituloPasivo->id, 'nombre' => 'Deudas', 'codigo' => 31]);
            $rubroRecursos = factory(\App\Rubro::class)->create(['id_capitulo' => $capituloResultado->id, 'nombre' => 'Recursos', 'codigo' => 51]);


            // Moneda
            $monedaCYBPesos = factory(\App\Moneda::class)->create(['id_rubro' => $rubroCajaYBanco->id, 'nombre' => 'Caja y bancos en pesos', 'codigo' => 111]);
            $monedaCreditoEnPesos = factory(\App\Moneda::class)->create(['id_rubro' => $rubroCreditos->id, 'nombre' => 'Creditos en pesos', 'codigo' => 131]);
            $monedaDeudaEnPesos = factory(\App\Moneda::class)->create(['id_rubro' => $rubroDeudas->id, 'nombre' => 'Deudas en pesos', 'codigo' => 311]);
            $monedaRecursosEnPesos = factory(\App\Moneda::class)->create(['id_rubro' => $rubroRecursos->id, 'nombre' => 'Recursos en pesos', 'codigo' => 511]);

            // Departamento
            $departamentoGeralCajaBanco = factory(\App\Departamento::class)->create(['id_moneda' => $monedaCYBPesos->id, 'nombre' => 'Caja y bancos Dpto general', 'codigo' => 11101]);
            $departamentoCreditoGeneral = factory(\App\Departamento::class)->create(['id_moneda' => $monedaCreditoEnPesos->id, 'nombre' => 'Creditos Dpto. General', 'codigo' => 13101]);
            $departamentoDeudasServicio = factory(\App\Departamento::class)->create(['id_moneda' => $monedaDeudaEnPesos->id, 'nombre' => 'Deudas Dpto servicio', 'codigo' => 31103]);
            $departamento3 = factory(\App\Departamento::class)->create(['id_moneda' => $monedaRecursosEnPesos->id, 'nombre' => 'Recursos Dpto general', 'codigo' => 51101]);
            $dptoGeneral= factory(\App\Departamento::class)->create(['id_moneda' => $monedaRecursosEnPesos->id, 'nombre' => 'Dpto general', 'codigo' => 51103]);

            // SubRubro
            $subRubro5 = factory(\App\SubRubro::class)->create(['id_departamento' => $departamentoGeralCajaBanco->id, 'nombre' => 'Caja Dpto general', 'codigo' => 1110101]);
            $subRubro4 = factory(\App\SubRubro::class)->create(['id_departamento' => $departamentoGeralCajaBanco->id, 'nombre' => 'Banco Dpto general', 'codigo' => 1110102]);
            $subRubroCreditos = factory(\App\SubRubro::class)->create(['id_departamento' => $departamentoCreditoGeneral->id, 'nombre' => 'Creditos', 'codigo' => 1310100]);
            $subRubroCredi = factory(\App\SubRubro::class)->create(['id_departamento' => $departamentoDeudasServicio->id, 'nombre' => 'Creditos', 'codigo' => 3110300]);
            $subRubro3 = factory(\App\SubRubro::class)->create(['id_departamento' => $departamento3->id, 'nombre' => 'Recursos especificos', 'codigo' => 5110101]);
            $subRubroRecursosEspecificos = factory(\App\SubRubro::class)->create(['id_departamento' => $dptoGeneral->id, 'nombre' => 'Recursos especificos', 'codigo' => 5110301]);

            // Imputaciones
            $imputacion3 = factory(\App\Imputacion::class)->create(['id_subrubro' => $subRubro3->id, 'nombre' => 'Cuotas sociales', 'codigo' => 511010101]);
            $imputacion4 = factory(\App\Imputacion::class)->create(['id_subrubro' => $subRubro4->id, 'nombre' => 'Banco xxx', 'codigo' => 111010201]);
            $imputacion5 = factory(\App\Imputacion::class)->create(['id_subrubro' => $subRubro5->id, 'nombre' => 'Caja - Efectivo', 'codigo' => 111010101]);

            // Saldos
            $saldoCuenta = factory(\App\SaldosCuentas::class)->create(['id_imputacion' => $imputacion3->id, 'codigo' => $imputacion3->codigo]);
            $saldoCuenta = factory(\App\SaldosCuentas::class)->create(['id_imputacion' => $imputacion4->id, 'codigo' => $imputacion4->codigo]);
            $saldoCuenta = factory(\App\SaldosCuentas::class)->create(['id_imputacion' => $imputacion5->id, 'codigo' => $imputacion5->codigo]);


            if($proveedores->isNotEmpty()){


                $primerProveedor = $proveedores->splice(1, 1);
                $primerProveedor = $primerProveedor->first();
                GeneradorDeCuentas::generar('Deudores ' . $primerProveedor->razon_social, '131010001');
                GeneradorDeCuentas::generar('Cta ' . $primerProveedor->razon_social, '311030001');
                GeneradorDeCuentas::generar('Comisiones ' . $primerProveedor->razon_social, '511030101');
                $proveedores->each(function ($proveedor) {
                    $codigo = ImputacionGateway::obtenerCodigoNuevo('1310100');
                    GeneradorDeCuentas::generar('Deudores ' . $proveedor->razon_social, $codigo);
                    $codigo = ImputacionGateway::obtenerCodigoNuevo('3110300');
                    GeneradorDeCuentas::generar('Cta ' . $proveedor->razon_social, $codigo);
                    $codigo = ImputacionGateway::obtenerCodigoNuevo('5110301');
                    GeneradorDeCuentas::generar('Comisiones ' . $proveedor->razon_social, $codigo);
                });

            }
            // Asiento de inicio
            $asiento = factory(\App\Asiento::class)->create(['id_ejercicio' => $ejercicio->id]);

            $user = Sentinel::registerAndActivate(array('usuario'=>'200', 'email'=>'1', 'password'=> '200'));
            $role = Sentinel::getRoleRepository()->createModel()->create([
                'name' => 'genio',
                'slug' => 'genio',
            ]);
            $role->permissions = ['organismos.crear' => true, 'organismos.visualizar' => true, 'organismos.editar' => true, 'organismos.borrar'=> true, 'socios.editar' => true, 'socios.visualizar' => true, 'socios.crear' => true, 'socios.borrar' => true];
            $role->save();
            $role->users()->attach($user);

            $this->call(PrioridadesSeed::class);
        });
    }
}
