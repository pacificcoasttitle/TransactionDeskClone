<?php
$request = $_GET['requrl'];
$request .= '&key=' . '22C75EF7-5DBF-4B26-B2DB-998BE080F29C';

$opts = array(
	"ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    ),
);

$context = stream_context_create($opts);
$file = file_get_contents($request,false,$context);
echo trim($file);