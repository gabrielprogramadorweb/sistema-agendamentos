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
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone', 14)->comment('(99)99999-9999');
            $table->string('coordinator', 70)->comment('Coordenador');
            $table->string('address', 128)->comment('Endereço da unidade');
            $table->json('services')->nullable()->comment('Conterá os identificadores dos serviços. Exemplo: ["1", "2", "...."]');
            $table->string('starttime', 6)->comment('Horário em que a unidade finaliza o expediente. Exemplo: 08:00');
            $table->string('endtime', 6)->comment('Horário em que a unidade inicia o expediente. Exemplo: 18:00');
            $table->string('servicetime', 20)->comment('Tempo necessário para cada atendimento. Exemplo: 1 hour, 10 minutes, 2 hours');
            $table->boolean('active')->default(false)->comment('0 => Não, 1 => Sim');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();  // Consider adding soft deletes if you might need logical deletion
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('units');
    }
};
