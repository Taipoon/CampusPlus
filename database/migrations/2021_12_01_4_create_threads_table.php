<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThreadsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('threads', function (Blueprint $table) {
      $table->id();
      $table->string('title');
      $table->foreignId('user_id');
      $table->integer('sort_order');
      $table->foreignId('secondary_category_id');
      $table->foreignId('status_id')
        ->constrained()->onUpdate('cascade')->onDelete('cascade');
      $table->boolean('is_anonymous')->default(0);
      $table->foreignId('best_answer_comment_id')
        ->nullable();
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
    Schema::dropIfExists('threads');
  }
}
