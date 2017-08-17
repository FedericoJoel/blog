<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('productos', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('id_proovedor')->unsigned();
            $table->foreign('id_proovedor')->references('id')->on('proovedores');
            $table->string('descripcion')->nullable();
            $table->string('tipo');
            $table->integer('ganancia');
            $table->string('nombre');
            $table->softDeletes();
        });
        Schema::enableForeignKeyConstraints();

    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos');
    }
}