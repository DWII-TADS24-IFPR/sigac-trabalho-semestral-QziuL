<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->boolean('permission');
            $table->unsignedBigInteger('resource_id');
            $table->unsignedBigInteger('role_id');
            $table->foreign('resource_id')->references('id')->on('resources');
            $table->foreign('role_id')->references('id')->on('roles');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
