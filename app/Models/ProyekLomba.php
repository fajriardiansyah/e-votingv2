<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProyekLomba extends Model
{
    use HasFactory;

    protected $fillable = [
        'pemilu_event_id', 
        'nama_proyek', 
        'tim_pengembang', 
        'deskripsi', 
        'foto_sampul',
        'url_proyek'];

    public function pemiluEvent(): BelongsTo
    {
        return $this->belongsTo(PemiluEvent::class);
    }

    public function logSuara()
    {
        return $this->hasMany(LogSuara::class, 'proyek_lomba_id');
    }
}