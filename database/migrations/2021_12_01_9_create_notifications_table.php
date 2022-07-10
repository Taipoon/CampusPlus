<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('notifications', function (Blueprint $table) {
      $table->id();

      $table->foreignId('from_user_id')
        ->constrained('students')
        ->onUpdate('cascade')
        ->onDelete('cascade');

      $table->foreignId('to_user_id')
        ->constrained('students')
        ->onUpdate('cascade')
        ->onDelete('cascade');

      $table->tinyInteger('type');

      $table->foreignId('comment_id')
        ->nullable()
        ->constrained('comments')
        ->onUpdate('cascade')
        ->onDelete('cascade');

      $table->foreignId('reply_comment_id')
        ->nullable()
        ->constrained('comments')
        ->onUpdate('cascade')
        ->onDelete('cascade');

      $table->foreignId('thread_id')
        ->nullable()
        ->constrained('threads')
        ->onUpdate('cascade')
        ->onDelete('cascade');

      $table->foreignId('direct_message_id')
        ->nullable()
        ->constrained('direct_messages')
        ->onUpdate('cascade')
        ->onDelete('cascade');

      $table->boolean('is_anonymous')->default(0);

      $table->boolean('is_already_read')->default(0);

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
    Schema::dropIfExists('notifications');
  }
}
