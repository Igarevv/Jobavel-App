<?php

use App\Persistence\Models\Employee;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employee_resume_file', function (Blueprint $table) {
            $table->bigInteger('id')->unsigned()->generatedAs()->always();
            $table->foreignIdFor(Employee::class, 'employee_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->string('file_id')->unique();
            $table->string('filename')->default('No name file');
            $table->primary('id');
        });

        Schema::create('employee_resume_skill', function (Blueprint $table) {
            $table->foreignIdFor(Employee::class, 'employee_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->integer('tech_skill_id')->unsigned();
            $table->foreign('tech_skill_id')
                ->references('id')
                ->on('tech_skills');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_resume_file');
        Schema::dropIfExists('employee_resume_skill');
    }

};
