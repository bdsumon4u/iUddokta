<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slides', function (Blueprint $table) {
            $table->id();
            $table->string('mobile_src');
            $table->string('desktop_src');
            $table->string('title')->nullable();
            $table->string('text')->nullable();
            $table->string('btn_name')->nullable();
            $table->string('btn_href')->nullable();
            $table->boolean('is_active')->default(0);
            $table->timestamps();
        });
    }

    /*
    CREATE TABLE slides (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        mobile_src VARCHAR(255) NOT NULL,
        desktop_src VARCHAR(255) NOT NULL,
        title VARCHAR(255) NULL,
        text VARCHAR(255) NULL,
        btn_name VARCHAR(20) NULL,
        btn_href VARCHAR(255) NULL,
        is_active TINYINT(1) DEFAULT 0,
        created_at TIMESTAMP NULL,
        updated_at TIMESTAMP NULL
    );
    */

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('slides');
    }
}
