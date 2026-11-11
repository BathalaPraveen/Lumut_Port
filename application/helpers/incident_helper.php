<?php
function uniqueIncRefId($key_word, $table, $select, $primaryid = 'id') {
    $ci = & get_instance();
    $cr_id = getIncMaxId($table, $select, $key_word, $primaryid);

    if ($cr_id == "") {
	$new_cr_id = $key_word . '-00001';
    } else {
	$old_cr_id = explode('-', $cr_id);

	$old_cr_id = $old_cr_id[0];

	str_pad($old_cr_id, 5, 4);
	$new_cr_id = $old_cr_id + 1;
	$length = strlen($new_cr_id);

	if ($length == 1) {
	    $newapp = $key_word . '-0000';
	} else if ($length == 2) {
	    $newapp = $key_word . '-000';
	} else if ($length == 3) {
	    $newapp = $key_word . '-00';
	} else if ($length == 4) {
	    $newapp = $key_word . '-0';
	} else if ($length == 5) {
	    $newapp = $key_word . '-';
	}

	$new_cr_id = $newapp . $new_cr_id;
    }

    return $new_cr_id;
}

function getIncMaxId($table, $select, $text = '', $orid = 'id') {
    $ci = & get_instance();
    $tlength = strlen($text);
    $substr = $tlength + 2;
    $ci->db->select($select . ' as max_val');
    //$ci->db->select('SUBSTRING(max(' . $select . ').' . $substr . ') as max_val');
    $ci->db->from($table);
    $ci->db->order_by($orid, "desc");
    $ci->db->like($select, $text);
    $ci->db->limit(1);
    $query = $ci->db->get();
    if ($query->num_rows() > 0) {
	$result = $query->row();
	$id = substr($result->max_val, $substr);
	return $id;
    }
}
?>