<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoodCommentsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('good_comments', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained('students')->onUpdate('cascade')->onDelete('cascade');
      $table->foreignId('comment_id')->constrained('comments')->onUpdate('cascade')->onDelete('cascade');
      $table->timestamps();
      $table->unique(['user_id', 'comment_id']);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('good_comments');
  }
}
