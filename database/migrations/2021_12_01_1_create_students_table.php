<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('students', function (Blueprint $table) {
      $table->id();
      $table->string('last_name');
      $table->string('first_name');
      $table->string('last_name_kana');
      $table->string('first_name_kana');
      $table->string('email')->unique();
      $table->foreignId('faculty_id')->constrained('faculties')->onUpdate('cascade')->onDelete('cascade');
      $table->string('profile', 100)->nullable();
      $table->string('profile_image_filename')->nullable()->constrained('profile_images');
      $table->string('icon_image_filename')->nullable()->constrained('icon_images');
      $table->string('twitter')->nullable();
      $table->string('instagram')->nullable();
      $table->string('github')->nullable();
      $table->string('youtube')->nullable();
      $table->string('url')->nullable();
      $table->string('information', 200)->nullable();
      $table->timestamp('email_verified_at')->nullable();
      $table->string('password');
      $table->string('api_access_token', 80)->nullable()->unique();
      $table->dateTime('last_login_at')->nullable();
      $table->dateTime('last_logout_at')->nullable();
      $table->rememberToken();
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
    Schema::dropIfExists('students');
  }
}
