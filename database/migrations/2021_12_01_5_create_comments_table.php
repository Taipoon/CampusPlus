<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('comments', function (Blueprint $table) {
      $table->id();
      $table->text('text');
      $table->foreignId('user_id')
        ->constrained('students')->onUpdate('cascade');
      $table->foreignId('thread_id')
        ->constrained()->onUpdate('cascade');
      $table->unsignedBigInteger('reply_to')->nullable()->default(null);
      $table->foreignId('image1')->nullable()
        ->constrained('images')->onUpdate('cascade')->onDelete('cascade');
      $table->foreignId('image2')->nullable()
        ->constrained('images')->onUpdate('cascade')->onDelete('cascade');
      $table->foreignId('image3')->nullable()
        ->constrained('images')->onUpdate('cascade')->onDelete('cascade');
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
    Schema::dropIfExists('comments');
  }
}
