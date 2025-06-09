<?php

use App\Enums\common\JobType;
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
        Schema::create('jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('company_id');
            $table->string('title');
            $table->string('location');
            $table->enum('type', JobType::list());
            $table->string('salary_range')->nullable();
            $table->text('description');
            $table->boolean('is_published');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('title', 'idx_jobs__title');
            $table->index('location', 'idx_jobs__location');
            $table->index('type', 'idx_jobs__type');
            $table->index('salary_range', 'idx_jobs_salary_range');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
