<?php

declare(strict_types=1);

use Cog\Laravel\Clickhouse\Migration\AbstractClickhouseMigration;

return new class extends AbstractClickhouseMigration
{
    public function up(): void
    {
        $this->clickhouseClient->write(
            <<<SQL
                CREATE TABLE IF NOT EXISTS user_points
                (
                    user_id UInt64,
                    timestamp DateTime,
                    latitude Float64,
                    longitude Float64
                )
                ENGINE = MergeTree
                ORDER BY (user_id, timestamp);
            SQL
        );
    }
};
