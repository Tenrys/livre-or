<?php
    function strtodatetime($time, $format = "Y-m-d H:i:s") {
        return date($format, strtotime($time));
    }

    function getUsername($db, $id) {
        $request = "SELECT login FROM utilisateurs WHERE id = ?";
        $stmt = $db->prepare($request);
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all();

        return $result["0"]["0"];
    }
?>