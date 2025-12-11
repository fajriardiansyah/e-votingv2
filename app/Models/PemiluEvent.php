<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PemiluEvent extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'tanggal_mulai', 'tanggal_selesai', 'aktif'];
    protected $casts = [
        'aktif' => 'boolean',
        'tanggal_mulai' => 'datetime',
        'tanggal_selesai' => 'datetime',
    ];

    public function proyekLombas(): HasMany
    {
        return $this->hasMany(ProyekLomba::class);
    }
}