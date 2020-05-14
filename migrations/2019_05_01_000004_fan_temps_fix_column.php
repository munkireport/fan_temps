<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Capsule\Manager as Capsule;

class FanTempsFixColumn extends Migration
{
    private $tableName = 'fan_temps';

    public function up()
    {
        $capsule = new Capsule();

        // Drop old format table
        $capsule::schema()->dropIfExists('fan_temps_pre_json');

        // Change column data type
        $capsule::schema()->table($this->tableName, function (Blueprint $table) {
            $table->integer('spht')->nullable()->change();
        });
    }

    public function down()
    {
        $capsule = new Capsule();
        // Change column data type
        $capsule::schema()->table($this->tableName, function (Blueprint $table) {
            $table->boolean('spht')->nullable()->change();
        });
    }
}
