<?php

declare(strict_types=1);

use Cog\Laravel\Clickhouse\Migration\AbstractClickhouseMigration;

return new class extends AbstractClickhouseMigration
{
    public function up(): void
    {
        $this->clickhouseClient->write(
            <<<SQL
                CREATE TABLE IF NOT EXISTS user_paths
                (
                    user_id UInt64,
                    start_time DateTime,
                    end_time DateTime,
                    path_geojson String,
                    path_length Float64,
                    path_points Array(Tuple(Float64, Float64))
                )
                ENGINE = MergeTree
                ORDER BY (user_id, start_time);
            SQL
        );
    }
};
