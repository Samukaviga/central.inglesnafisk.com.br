<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
         Schema::table('registrations', function (Blueprint $table) {
            // renomear coluna
            $table->renameColumn('course', 'course_1');

            // adicionar novas colunas
            $table->string('course_2', 60)->nullable()->after('course_1');
            $table->string('course_3', 60)->nullable()->after('course_2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            // remover colunas adicionadas
            $table->dropColumn(['course_2', 'course_3']);

            // voltar nome original
            $table->renameColumn('course_1', 'course');
        });
    }
};
