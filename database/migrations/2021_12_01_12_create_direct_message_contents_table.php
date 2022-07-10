<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDirectMessageContentsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('direct_message_contents', function (Blueprint $table) {
      $table->id();

      $table->text('content');

      $table->foreignId('sender_id')
        // ->constrained('students')
        ->onUpdate('cascade')
        ->onDelete('cascade');

      $table->foreignId('recipient_id')
        // ->constrained('students')
        ->onUpdate('cascade')
        ->onDelete('cascade');

      $table->foreignId('direct_message_id')
        // ->constrained('direct_messages')
        ->onUpdate('cascade')
        ->onDelete('cascade');

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
    Schema::dropIfExists('direct_message_contents');
  }
}
