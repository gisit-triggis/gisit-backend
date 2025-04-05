<?php

namespace Database\Seeders;

use App\Models\City;
use App\Support\enums\LogLevel;
use Clickbar\Magellan\Data\Geometries\MultiPolygon;
use Clickbar\Magellan\Data\Geometries\Point;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Uid\Ulid;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        $this->seedRegionsFromGeoJson();
        $this->seedCitiesFromGeoJson();
    }

    private function seedRegionsFromGeoJson(): void
    {
        $geojson = Storage::disk('public')->get('territory.geojson');
        $data = json_decode($geojson, true);
        log_message(LogLevel::DEBUG, json_encode($data));
        foreach ($data['features'] as $feature) {
            $properties = $feature['properties'];
            $name = $properties['NAME'] ?? null;
            if (!$name) {
                continue;
            }

            log_message(LogLevel::INFO, $name);

            $wkt = $this->convertCoordinatesToWkt($feature['geometry']['coordinates']);
            $fid = $properties['fid'];
            $ulid = strtolower(Ulid::generate());

            $sql = "
                INSERT INTO regions (id, fid, title, geometry)
                VALUES (?, ?, ?, ST_GeomFromText(?, 3857))
            ";

            DB::statement($sql, [
                $ulid,
                $fid,
                $name,
                $wkt,
            ]);
        }
    }

    private function seedCitiesFromGeoJson(): void
    {
        $geojson = Storage::disk('public')->get('cities.geojson');
        $data = json_decode($geojson, true);

        foreach ($data['features'] as $feature) {
            $properties = $feature['properties'];
            if (($properties['PLACE'] ?? '') === 'locality') {
                continue;
            }

            $coordinates = $feature['geometry']['coordinates'];

            $city = City::firstOrNew(['title' => $properties['NAME']]);
            $city->fid = $properties['fid'];
            $city->title = $properties['NAME'];
            $city->place = $properties['PLACE'];
            $city->population = ($city->population ?? 0) + ($properties['POPULATION'] ?? 0);
            $city->geometry = Point::make($coordinates[0], $coordinates[1]);
            $city->region_id = $this->getRegionIdFromCoordinates($coordinates);
            $city->save();
        }
    }

    private function convertCoordinatesToWkt(array $coordinates): string
    {
        $polygons = array_map(function ($polygon) {
            $rings = array_map(function ($ring) {
                $points = array_map(fn($coord) => implode(' ', $coord), $ring);
                return '(' . implode(',', $points) . ')';
            }, $polygon);

            return '(' . implode(',', $rings) . ')';
        }, $coordinates);

        return 'MULTIPOLYGON(' . implode(',', $polygons) . ')';
    }

    private function getRegionIdFromCoordinates(array $coordinates): ?string
    {
        $pointWkt = "POINT($coordinates[0] $coordinates[1])";

        $result = DB::selectOne("
            SELECT id
            FROM regions
            WHERE ST_Contains(geometry::geometry, ST_GeomFromText(?, 3857)::geometry)
        ", [$pointWkt]);

        if ($result) {
            return $result->id;
        }

        echo "Точка ($coordinates[0], $coordinates[1]) не принадлежит ни одному из регионов.\n";
        return null;
    }
}
