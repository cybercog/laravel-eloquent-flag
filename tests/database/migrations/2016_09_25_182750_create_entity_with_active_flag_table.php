<?php

/*
 * This file is part of Laravel Eloquent Flag.
 *
 * (c) CyberCog <support@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateEntityWithActiveFlagTable.
 */
class CreateEntityWithActiveFlagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entity_with_active_flag', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->boolean('is_active');
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
        Schema::drop('entity_with_active_flag');
    }
}
