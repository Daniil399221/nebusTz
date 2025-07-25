<?php

use App\Models\Activity;
use App\Models\Building;
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
        Schema::create('organizations', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('name')->index();
            $table->string('slug')->unique();
            $table->string('phone');
            $table->foreignIdFor(Activity::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Building::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }
};
