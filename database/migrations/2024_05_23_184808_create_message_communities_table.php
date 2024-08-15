<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message_communities', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained('users');
            $table->foreignId("author_id")->constrained('users');
            $table->foreignId("community_id")->constrained('communities');
            $table->text('message')->nullable();
            $table->text('image')->nullable();
            $table->text('username')->nullable();
            $table->text('user_photo')->nullable();
            $table->text('file')->nullable();
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
        Schema::dropIfExists('message_communities');
    }
};
