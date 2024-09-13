<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

function dropColumnIfExist($tableName, $columnName){
    Schema::table($tableName, function (Blueprint $table) use($tableName, $columnName){
        if (Schema::hasColumn($tableName, $columnName)) {
            $table->dropColumn($columnName);
        }
    });
}
