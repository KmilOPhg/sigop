<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class BodegaMaterialSeeder extends Seeder
{
    /**
     * Llena bodega y materiales con datos de prueba (referencias e ítems únicos).
     */
    public function run(): void
    {
        $userId = User::query()->orderBy('id')->value('id');
        if (! $userId) {
            $this->command?->warn('No hay usuarios. Ejecuta AdminUserSeeder antes.');

            return;
        }

        if (DB::table('bodega')->where('referencia', 'BD-001')->exists()) {
            $this->command?->info('BodegaMaterialSeeder: omitido (ya existen datos de prueba, p. ej. BD-001).');

            return;
        }

        $now = Carbon::now();

        $bodegaRows = $this->buildBodegaRows($now);
        $materialRows = $this->buildMaterialRows($userId, $now);

        foreach (array_chunk($bodegaRows, 100) as $chunk) {
            DB::table('bodega')->insert($chunk);
        }
        foreach (array_chunk($materialRows, 100) as $chunk) {
            DB::table('materiales')->insert($chunk);
        }

        $this->command?->info(sprintf(
            'BodegaMaterialSeeder: %d bodegas, %d materiales.',
            count($bodegaRows),
            count($materialRows)
        ));
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function buildBodegaRows(Carbon $now): array
    {
        $descripciones = [
            'Almacén general planta norte',
            'Materiales de confección — zona A',
            'Insumos textiles baja rotación',
            'Reserva de hilos y elásticos',
            'Bodega de avíos y accesorios',
            'Prendas terminadas — despacho',
            'Muestras y prototipos',
            'Devoluciones y reproceso',
            'Materia prima importada',
            'Químicos y auxiliares lavandería',
            'Empaque y embalaje',
            'Repuestos de maquinaria',
            'Herrajes y broches',
            'Telas planas — rack 1',
            'Telas planas — rack 2',
            'Tejido de punto — bobinas',
            'Cuero sintético y forros',
            'Espumas e interiores',
            'Etiquetas y cintas',
            'Control de calidad — retención',
        ];

        $rows = [];
        for ($i = 1; $i <= 90; $i++) {
            $ref = 'BD-'.str_pad((string) $i, 3, '0', STR_PAD_LEFT);
            $desc = $descripciones[($i - 1) % count($descripciones)];
            if ($i > count($descripciones)) {
                $desc .= ' — ext '.(int) floor(($i - 1) / count($descripciones));
            }
            $desc = mb_substr($desc, 0, 50);
            $estado = ($i % 11 === 0) ? 'inactivo' : 'activo';

            $rows[] = [
                'referencia' => $ref,
                'descripcion' => $desc,
                'estado' => $estado,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        return $rows;
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function buildMaterialRows(int $userId, Carbon $now): array
    {
        $unidades = ['UND', 'KLS', 'MTS', 'LAM', 'PAR', 'DCM', 'LTS', 'CM', 'RLL', 'GLS', 'LAT', 'LBS', 'BTS', 'GRS', 'DOC', 'GRAM'];

        $nombresBase = [
            'Hilo poliéster 40/2',
            'Hilo algodón cardado',
            'Elástico braided 6mm',
            'Cierre invisible 18cm',
            'Botón nácar 15mm',
            'Broche presión niquelado',
            'Tela drill algodón 240g',
            'Tela popelín peinado',
            'Forro acetato antiestático',
            'Entretela fusible liviana',
            'Cinta bias algodón',
            'Cordón tip hoodie algodón',
            'Etiqueta tejida damasco',
            'Parche reflectante termo',
            'Hilo conductivo ESD',
            'Espuma EVA 3mm',
            'Cuero sintético grabado',
            'Ojal metálico anodizado',
            'Hilo overlock 150D',
            'Cinta métrica fibra 150cm',
            'Tijera industrial 10"',
            'Aguja DPx5 R110',
            'Aceite máquina plana',
            'Guía magnética costura',
            'Lápiz marcar tela soluble',
            'Bolsa polipropileno 40x50',
            'Gancho ajustable hebilla',
            'Tela mesh deportivo',
            'Hilo bordar rayon 4000m',
            'Velcro hook & loop 20mm',
        ];

        $rows = [];
        for ($i = 1; $i <= 160; $i++) {
            $item = 'ITM-'.str_pad((string) $i, 5, '0', STR_PAD_LEFT);
            $base = $nombresBase[($i - 1) % count($nombresBase)];
            $nombre = mb_substr($base.' lote '.$i, 0, 50);
            $unidad = $unidades[$i % count($unidades)];
            $estado = ($i % 13 === 0) ? 'inactivo' : 'activo';

            $rows[] = [
                'item_material' => $item,
                'nombre_material' => $nombre,
                'unidad_medida' => $unidad,
                'estado' => $estado,
                'user_id' => $userId,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        return $rows;
    }
}
