<?php
/**
 * Created by PhpStorm.
 * User: Stephan Wörner
 * Date: 19.07.2018
 * Time: 10:12
 */

if (!extension_loaded('mssql')) {
    /** @var PDO $globalPdoConnection */
    $globalPdoConnection = null;
    $globalPdoStatements = [];
    $globalPdoHostname = null;
    $globalPdoUser = null;
    $globalPdoPassword = null;
    function mssql_connect(
        $hostname = null,
        $username = null,
        $password = null
    ) {
        global $globalPdoHostname, $globalPdoUser, $globalPdoPassword;

        $globalPdoHostname = $hostname;
        $globalPdoUser = $username;
        $globalPdoPassword = $password;

    }

    function mssql_select_db($database, &$mssql_connect)
    {
        global $globalPdoHostname, $globalPdoUser, $globalPdoPassword, $globalPdoConnection;
        $globalPdoConnection = $mssql_connect = new PDO (
            'dblib:host=' . $globalPdoHostname . ';dbname=' . $database,
            $globalPdoUser,
            $globalPdoPassword
        );
    }

    function mssql_query($query)
    {
        /** @var PDO $globalPdoConnection */
        global $globalPdoConnection, $globalPdoStatements;
        $stm = $globalPdoConnection->prepare($query);
        $stm->execute();
        if ($globalPdoConnection->errorInfo()[0] != '00000') {
            echo $query;
            print_r($globalPdoConnection->errorInfo());
            die();
        }
        $uniqueid = uniqid();
        $globalPdoStatements[$uniqueid] = $stm;
        return $uniqueid;
    }


    function mssql_fetch_assoc($stmId, $fetch_style = PDO::FETCH_ASSOC)
    {
        global $globalPdoStatements;
        $stm = $globalPdoStatements[$stmId];
        $ret = $stm->fetch($fetch_style);
        return $ret;
    }

    function mssql_num_rows($stmId)
    {
        global $globalPdoStatements;
        $stm = $globalPdoStatements[$stmId];
        $ret = $stm->rowCount();
        return $ret;
    }

    function  mssql_fetch_object($stmId){
        return mssql_fetch_assoc($stmId, $fetch_style = PDO::FETCH_OBJ);
    }
    
    /**
     * feel free to add more functions
     */
}

