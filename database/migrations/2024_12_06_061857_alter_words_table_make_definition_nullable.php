<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('words', function (Blueprint $table) {
        $table->string('definition')->nullable()->change();
    });
}

public function down()
{
    Schema::table('words', function (Blueprint $table) {
        $table->string('definition')->nullable(false)->change();
    });
}
};
