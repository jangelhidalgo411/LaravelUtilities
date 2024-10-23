<?php

//use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Carbon\Carbon;

function Test() {
	return 'Si Furula';
}

function SafeQueryException($exception) {
    $ExceptionMessage = '';

    switch ($exception) { 
        case '1049':
            $ExceptionMessage = 'Unknown database - probably config error';
            break;
        case '2002':
            $ExceptionMessage = 'Databaseis down';
            break;
        case '23000':
            $ExceptionMessage = 'Already exist or Number too long';
            break;
        case '42000':
            $ExceptionMessage = 'Data Field Not valid';
            break;
        case '22001':
            $ExceptionMessage = 'Data too long';
            break;
        case '22007':
            $ExceptionMessage = 'Trying To Insert An String as date';
            break;
        case '22018':
            $ExceptionMessage = 'Trying To Insert An String as Number';
            break;
        case '42S22':
            $ExceptionMessage = 'Unknown column on table';
            break;
        default:
            $ExceptionMessage = 'Untrapped Error.';
            break;
    }

    return $ExceptionMessage;
}


function AddRecord($Table, $MainData, $OptionalData, $AlloWUpdate) {
    $Count = DB::table($Table)->where($MainData)->count();
    $AddRecordMsg = 'Import/Update Successfully';

    if($Count == 0 || $AlloWUpdate) {
        DB::beginTransaction();
        try {
            DB::table($Table)->updateOrInsert($MainData, $OptionalData);
        } catch(QueryException $ex) {
            DB::rollback();
            $AddRecordMsg = SafeQueryException($ex->getCode())." - ".$ex->getMessage();
        }            
        DB::commit();
    }
    else {
        $AddRecordMsg = 'Already exist. no update requested.';
    }

    return $AddRecordMsg;
}

function GetOptions($Table, $Value, $Caption, $Orderby) {

    $Options = DB::table($Table)->select(DB::raw("$Value as Value"), DB::raw("$Caption as Caption"));
                
    if($Orderby !== '')
        $Options->orderBy($Orderby, 'asc');

    return $Options->distinct()->get();
}


function BooleanOptions() {
    $Options = [
        (object) ['Value' => '1', 'Caption' => 'Yes'],
        (object) ['Value' => '0', 'Caption' => 'No'],
    ];

    return $Options;
}

function MTGCardOptions() {
    $Options = [
        (object) ['Value' => 'W', 'Caption' => 'White'],
        (object) ['Value' => 'U', 'Caption' => 'Blue'],
        (object) ['Value' => 'B', 'Caption' => 'Black'],
        (object) ['Value' => 'R', 'Caption' => 'Red'],
        (object) ['Value' => 'G', 'Caption' => 'Green'],
        (object) ['Value' => 'C', 'Caption' => 'Colorless'],
    ];

    return $Options;
}