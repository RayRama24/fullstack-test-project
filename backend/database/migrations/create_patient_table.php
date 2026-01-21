<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('medical_record_no')->unique();
            $table->text('nik');            // encrypted
            $table->string('nik_hash');     // for searching
            $table->text('email');          // encrypted
            $table->string('name');
            // $table->date('birth_date');
            $table->text('address'); 
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('patients');
    }
};
