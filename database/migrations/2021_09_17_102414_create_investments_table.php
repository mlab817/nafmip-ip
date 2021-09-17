<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvestmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('investments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commodity_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->foreignId('intervention_id')->nullable()->constrained()->cascadeOnDelete();
            $table->text('description')->nullable();
            $table->decimal('quantity', 15, 2)->default(0);
            $table->decimal('cost',15,4)->default(0);
            $table->point('location_map')->nullable();
            $table->year('year')->nullable();
            $table->string('proponent')->nullable();
            $table->string('beneficiaries')->nullable();
            $table->text('justification')->nullable();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->text('remarks')->nullable();
            $table->foreignId('validated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('investments');
    }
}
