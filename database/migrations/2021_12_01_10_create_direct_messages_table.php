<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDirectMessagesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('direct_messages', function (Blueprint $table) {
      $table->id();

      $table->foreignId('first_user_id')
        // ->constrained('students')
        ->onUpdate('cascade')
        ->onDelete('cascade');

      $table->foreignId('second_user_id')
        ->onUpdate('cascade')
        ->onDelete('cascade');

      $table->foreignId('notification_id')
        // ->constrained('notifications')
        ->onUpdate('cascade')
        ->onDelete('cascade');

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('direct_messages');
  }
}
