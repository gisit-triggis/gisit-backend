<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use ClickHouseDB\Client as ClickHouseClient;

class CollectUserPaths extends Command
{
    protected $signature = 'gps:collect-user-paths';
    protected $description = 'Collect finished user paths from user_points and write them to user_paths';

    public function handle()
    {
        $clickhouse = app(ClickHouseClient::class);

        $this->info('Collecting user paths...');

        $users = $clickhouse->select("SELECT DISTINCT user_id FROM user_points")->rows();

        foreach ($users as $row) {
            $userId = $row['user_id'];

            $this->info("Processing user $userId...");

            $points = $clickhouse->select("
                SELECT timestamp, latitude, longitude
                FROM user_points
                WHERE user_id = $userId
                ORDER BY timestamp
            ")->rows();

            if (count($points) < 2) {
                continue;
            }

            $paths = [];
            $currentPath = [];
            $startTime = null;
            $lastTime = null;

            foreach ($points as $point) {
                $time = Carbon::parse($point['timestamp']);

                if ($lastTime && $time->diffInMinutes($lastTime) > 10) {
                    if (count($currentPath) > 1) {
                        $paths[] = [
                            'start_time' => $startTime,
                            'end_time' => $lastTime,
                            'points' => $currentPath,
                        ];
                    }

                    $currentPath = [];
                    $startTime = $time;
                }

                $currentPath[] = [$point['longitude'], $point['latitude']];
                $lastTime = $time;

                if (!$startTime) {
                    $startTime = $time;
                }
            }

            if (count($currentPath) > 1) {
                $paths[] = [
                    'start_time' => $startTime,
                    'end_time' => $lastTime,
                    'points' => $currentPath,
                ];
            }

            foreach ($paths as $path) {
                $geojson = json_encode([
                    'type' => 'LineString',
                    'coordinates' => $path['points'],
                ]);

                $clickhouse->insert('user_paths', [[
                    'user_id' => (int) $userId,
                    'start_time' => $path['start_time']->toDateTimeString(),
                    'end_time' => $path['end_time']->toDateTimeString(),
                    'path_geojson' => $geojson,
                    'path_length' => 0.0, // можно позже рассчитать
                    'path_points' => array_map(function ($p) {
                        return [(float) $p[1], (float) $p[0]]; // lat, lon
                    }, $path['points']),
                ]], ['user_id', 'start_time', 'end_time', 'path_geojson', 'path_length', 'path_points']);

                $clickhouse->write(<<<SQL
                    ALTER TABLE user_points DELETE
                    WHERE user_id = $userId
                      AND timestamp BETWEEN '{$path['start_time']->toDateTimeString()}' AND '{$path['end_time']->toDateTimeString()}'
                SQL);
            }
        }

        $this->info('Done!');
    }
}
