<?php
use CodeIgniter\Database\Exceptions\DatabaseException;

    /**
     * default response
     * */
    function defaultResponseApi($status = false, $message = "You don't have access for this resource, please contact administrator.", $ipaddr = '::1', $errcode = 'IDNT-1001', $result = null) {
        if ($status)
            $response = array(
                'status'    => $status,
                'message'   => $message,
                'result'    => $result,
            );
        else
            $response = array(
                'status'    => $status,
                'message'   => $message,
                'ipaddr'    => $ipaddr,
                'errCode'   => $errcode
            );

        return $response;
    }
?>