<?php
$dataDecoded = json_decode($data);
?>

<div class='btn-group'>
    <a href="{{ route($dataDecoded->type . '.show',  $dataDecoded->id) }}" target="_blank" class='btn btn-default btn-xs'>
        <i class="fas fa-link"></i>
    </a>
    <button class="btn btn-danger btn-xs" onclick="confirmDelete('notifications', '{{$id}}')">
        <i class="fas fa-trash"></i>
    </button>
</div>
