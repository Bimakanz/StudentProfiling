<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'user_id',
    'judul',
    'deskripsi',
    'link_github',
    'thumbnail',
    'kategori',
    'nilai',
    'jenis_porto',
    'tools',
    'teknologi',
])]
class Portofolio extends Model
{
    /** @use HasFactory<\Database\Factories\PortofolioFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'nilai' => 'string',
        ];
    }

    /**
     * Relasi ke model User (pemilik portofolio).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
