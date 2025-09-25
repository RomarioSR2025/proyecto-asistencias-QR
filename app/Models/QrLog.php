<?php
namespace App\Models;

use CodeIgniter\Model;

class QrLog extends Model
{
    protected $table      = 'qr_logs';
    protected $primaryKey = 'idlog';
    protected $allowedFields = [
        'idmatricula', 'fecha', 'hora', 'tipo', 'dispositivo'
    ];
}
