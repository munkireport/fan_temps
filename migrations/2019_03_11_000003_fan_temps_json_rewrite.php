<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Capsule\Manager as Capsule;

class FanTempsJsonRewrite extends Migration
{
    private $tableName = 'fan_temps';
    private $tableNameV2 = 'fan_temps_pre_json';

    public function up()
    {
        $capsule = new Capsule();
        $migrateData = false;

        // Check if previous migrations have failed
        if ($capsule::schema()->hasTable($this->tableNameV2)) {
            // Migration already failed before, but didnt finish
            throw new Exception("previous failed migration exists");
        }

        // Check if old table exists
        if ($capsule::schema()->hasTable($this->tableName)) {
            $capsule::schema()->rename($this->tableName, $this->tableNameV2);
            $migrateData = true;
        }

        // Create new table
        $capsule::schema()->create($this->tableName, function (Blueprint $table) {
            $table->increments('id');
            $table->string('serial_number');
            $table->integer('f0ac')->nullable();
            $table->integer('f1ac')->nullable();
            $table->integer('f2ac')->nullable();
            $table->integer('f3ac')->nullable();
            $table->integer('f4ac')->nullable();
            $table->integer('f5ac')->nullable();
            $table->integer('f6ac')->nullable();
            $table->integer('f7ac')->nullable();
            $table->integer('f8ac')->nullable();
            $table->integer('f0mn')->nullable();
            $table->integer('f1mn')->nullable();
            $table->integer('f2mn')->nullable();
            $table->integer('f3mn')->nullable();
            $table->integer('f4mn')->nullable();
            $table->integer('f5mn')->nullable();
            $table->integer('f6mn')->nullable();
            $table->integer('f7mn')->nullable();
            $table->integer('f8mn')->nullable();
            $table->integer('f0mx')->nullable();
            $table->integer('f1mx')->nullable();
            $table->integer('f2mx')->nullable();
            $table->integer('f3mx')->nullable();
            $table->integer('f4mx')->nullable();
            $table->integer('f5mx')->nullable();
            $table->integer('f6mx')->nullable();
            $table->integer('f7mx')->nullable();
            $table->integer('f8mx')->nullable();
            $table->string('f0id')->nullable();
            $table->string('f1id')->nullable();
            $table->string('f2id')->nullable();
            $table->string('f3id')->nullable();
            $table->string('f4id')->nullable();
            $table->string('f5id')->nullable();
            $table->string('f6id')->nullable();
            $table->string('f7id')->nullable();
            $table->string('f8id')->nullable();
            $table->float('ta0p')->nullable();
            $table->float('tc0f')->nullable();
            $table->float('tc0d')->nullable();
            $table->float('tc0p')->nullable();
            $table->float('tb0t')->nullable();
            $table->float('tb1t')->nullable();
            $table->float('tb2t')->nullable();
            $table->float('tg0d')->nullable();
            $table->float('tg0h')->nullable();
            $table->float('tg0p')->nullable();
            $table->float('tl0p')->nullable();
            $table->float('th0p')->nullable();
            $table->float('th0h')->nullable();
            $table->float('th1h')->nullable();
            $table->float('th2h')->nullable();
            $table->float('tm0p')->nullable();
            $table->float('ts0p')->nullable();
            $table->float('tn0h')->nullable();
            $table->float('tn0d')->nullable();
            $table->float('tn0p')->nullable();
            $table->float('tp0p')->nullable();
            $table->float('tm0s')->nullable();
            $table->integer('alsl')->nullable();
            $table->integer('fnum')->nullable();
            $table->boolean('fnfd')->nullable();
            $table->boolean('lsof')->nullable();
            $table->boolean('msld')->nullable();
            $table->boolean('spht')->nullable();
            $table->integer('mssd')->nullable();
            $table->boolean('mssf')->nullable();
            $table->boolean('mstm')->nullable();
            $table->boolean('sght')->nullable();
            $table->integer('sph0')->nullable();
            $table->boolean('msdi')->nullable();
            $table->mediumText('json_info')->nullable();
        });

        // Move data from old table to new
        if ($migrateData) {
            $capsule::unprepared("INSERT INTO 
                $this->tableName
                (id, serial_number, f0ac, f1ac, f2ac, f3ac, f4ac, f5ac, f6ac, f7ac, f8ac,
                 f0mn, f1mn, f2mn, f3mn, f4mn, f5mn, f6mn, f7mn, f8mn, f0mx, f1mx, f2mx,
                 f3mx, f4mx, f5mx, f6mx, f7mx, f8mx, f0id, f1id, f2id, f3id, f4id, f5id,
                 f6id, f7id, f8id, ta0p, tc0f, tc0d, tc0p, tb0t, tb1t, tb2t, tg0d, sph0,
                 tg0h, tg0p, tl0p, th0p, th0h, th1h, th2h, tm0p, ts0p, tn0h, tn0d, tn0p,
                 tp0p, alsl, fnum, fnfd, lsof, msld, spht, mssd, mssf, mstm, sght, tm0s
                )
            SELECT
                id, serial_number, fan_0, fan_1, fan_2, fan_3, fan_4, fan_5, fan_6, fan_7, fan_8, fanmin0,
                fanmin1, fanmin2, fanmin3, fanmin4, fanmin5, fanmin6, fanmin7, fanmin8,
                fanmax0, fanmax1, fanmax2, fanmax3, fanmax4, fanmax5, fanmax6, fanmax7,
                fanmax8, fanlabel0, fanlabel1, fanlabel2, fanlabel3, fanlabel4, fanlabel5,
                fanlabel6, fanlabel7, fanlabel8,  ta0p, tc0f, tc0d, tc0p, tb0t, sph0,
                tb1t, tb2t, tg0d, tg0h, tg0p, tl0p, th0p, th0h, th1h, th2h, tm0p, ts0p,
                tn0h, tn0d, tn0p, tp0p, alsl, fnum, fnfd, lsof, msld, spht, mssd, mssf,
                mstm, sght, tm0s
            FROM
                $this->tableNameV2");
            
            // Commented out to keep old table around for now
            $capsule::schema()->drop($this->tableNameV2);
        }

        // Create indexes
        $capsule::schema()->table($this->tableName, function (Blueprint $table) {
            $table->index('serial_number');
            $table->index('f0ac');
            $table->index('f1ac');
            $table->index('f2ac');
            $table->index('f0mn');
            $table->index('f1mn');
            $table->index('f2mn');
            $table->index('f0mx');
            $table->index('f1mx');
            $table->index('f2mx');
            $table->index('f0id');
            $table->index('f1id');
            $table->index('f2id');
            $table->index('ta0p');
            $table->index('tc0f');
            $table->index('tc0d');
            $table->index('tc0p');
            $table->index('tb0t');
            $table->index('tb1t');
            $table->index('tg0d');
            $table->index('tg0h');
            $table->index('tg0p');
            $table->index('tl0p');
            $table->index('th0p');
            $table->index('th0h');
            $table->index('th1h');
            $table->index('th2h');
            $table->index('tm0p');
            $table->index('ts0p');
            $table->index('tn0h');
            $table->index('tn0d');
            $table->index('tn0p');
            $table->index('tp0p');
            $table->index('alsl');
            $table->index('msdi');
            $table->index('fnum');
            $table->index('fnfd');
            $table->index('lsof');
            $table->index('msld');
            $table->index('spht');
            $table->index('mssd');
            $table->index('mssf');
            $table->index('mstm');
            $table->index('sght');
            $table->index('sph0');
        });
    }
    
    public function down()
    {
        $capsule = new Capsule();
        $capsule::schema()->dropIfExists($this->tableName);
        if ($capsule::schema()->hasTable($this->tableNameV2)) {
            $capsule::schema()->rename($this->tableNameV2, $this->tableName);
        }
    }
}
