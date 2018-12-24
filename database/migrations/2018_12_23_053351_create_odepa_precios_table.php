<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOdepaPreciosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('odepa_precios', function(Blueprint $table)
		{
			$table->string('region', 30)->nullable();
			$table->integer('semana');
			$table->string('fecha_inicio', 12);
			$table->string('fecha_termino', 12);
			$table->string('sector', 50)->nullable();
			$table->string('tipo_punto_monitoreo', 50)->nullable();
			$table->string('tipo_producto', 50);
			$table->string('producto', 50);
			$table->string('variedad', 50)->nullable();
			$table->string('calidad', 50)->nullable();
			$table->string('unidad', 50)->nullable();
			$table->string('procedencia', 50)->nullable();
			$table->integer('precio_mínimo')->nullable();
			$table->integer('precio_máximo')->nullable();
			$table->integer('precio_promedio');
			$table->integer('id', true);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('odepa_precios');
	}

}
