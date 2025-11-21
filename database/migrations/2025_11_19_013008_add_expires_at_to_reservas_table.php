<?php
    /**
     * Para cualquiera que vea esto, esta forma de agregar columnas a la base de datos es muy profesional y ayuda a
     *  gestionar las versiones del proyecto pudiendo saber que cambios hemos hechos☝️🤓☝️🤓
     * ☝️🤓☝️🤓☝️🤓 y si este comentario es muy necesario
     * pd:Dixon estuvo aqui
     */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('reservas', function (Blueprint $table) {
            $table->timestamp('expires_at')->nullable()->after('fecha_pago');
        });
    }

    public function down()
    {
        Schema::table('reservas', function (Blueprint $table) {
            $table->dropColumn('expires_at');
        });
    }
};