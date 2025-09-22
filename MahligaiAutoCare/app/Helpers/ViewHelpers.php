<?php
if (!function_exists('getStatusClass')) {
    function getStatusClass(string $status): string {
        return match (strtolower($status)) {
            'completed' => 'success',
            'confirmed' => 'primary', 
            'pending', 'awaiting confirmation' => 'warning',
            'cancelled', 'rejected' => 'danger',
            default => 'secondary',
        };
    }
}
?>