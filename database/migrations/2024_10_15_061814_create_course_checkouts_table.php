<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("course_checkout", function (Blueprint $table) {
            $table->id();
            $table
                ->foreignId("checkout_id")
                ->constrained()
                ->onDelete("cascade");
            $table->foreignId("course_id")->constrained()->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("course_checkout");
    }
};
