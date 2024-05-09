<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->boolean('finished')->default(false); // Adiciona o campo finished com valor padrão como false
            $table->boolean('canceled')->default(false); // Adiciona o campo canceled com valor padrão como false
            $table->dateTime('chosen_date')->nullable(); // Adiciona o campo chosen_date que pode ser nulo
        });
    }

    /**
     * Reverte as migrações.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->dropColumn(['finished', 'canceled', 'chosen_date']);
        });
    }
};
