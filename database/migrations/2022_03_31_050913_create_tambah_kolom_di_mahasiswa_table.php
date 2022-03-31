<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTambahKolomDiMahasiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tambah_kolom_di_mahasiswa', function (Blueprint $table) {
            Schema::table('mahasiswa', function (Blueprint $table) {
                $table->string('email', 50)->after('nama')->nullable();
                $table->string('jenis_kelamin', 10)->after('email')->nullable();
                $table->string('tanggal_lahir', 100)->after('jenis_kelamin')->nullable();
                $table->string('alamat', 100)->after('tanggal_lahir')->nullable();
               
            });
    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->dropColumn('email');
            $table->dropColumn('jenis_kelamin');
            $table->dropColumn('tanggal_lahir');
            $table->dropColumn('alamat');
        
            
        });

    }
}
