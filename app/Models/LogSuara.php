<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LogSuara extends Model
{
    use HasFactory;

    // Catatan: Tidak perlu 'protected $table = 'log_suaras';' karena Laravel sudah default ke jamak.
    // Jika masih error, coba tambahkan 'protected $table = 'log_suaras';'
    
    protected $fillable = [
        'pemilu_event_id', 
        'proyek_lomba_id', 
        'identitas_voter', 
        'tipe_voter', 
        'kategori_internal', 
        'jabatan_eksternal', 
        'nama_perusahaan', 
        'ip_pemilih', 
        'perangkat_pemilih'
    ];

    public function pemiluEvent(): BelongsTo
    {
        return $this->belongsTo(PemiluEvent::class);
    }

    public function proyekLomba(): BelongsTo
    {
        return $this->belongsTo(ProyekLomba::class);
    }
}