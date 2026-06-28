<?php

namespace App\Models;

// Eloquent: User model bawaan Laravel, ditambah role, status,
// dan accessor `initials` & `formatted_joined` yang dipakai di admin/index.blade.php

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Dipakai di admin/index.blade.php -> {{ $admin->initials }}
    // dan app.blade.php -> {{ $user->initials() }}
    public function getInitialsAttribute(): string
    {
        return $this->initials();
    }

    public function initials(): string
    {
        $parts   = preg_split('/\s+/', trim($this->name ?? ''));
        $first   = $parts[0] ?? '';
        $second  = $parts[1] ?? '';
        $result  = mb_strtoupper(mb_substr($first, 0, 1) . mb_substr($second, 0, 1));
        return $result !== '' ? $result : 'NA';
    }

    // Dipakai di admin/index.blade.php -> {{ $admin->formatted_joined }}
    public function getFormattedJoinedAttribute(): string
    {
        return $this->created_at?->translatedFormat('d M Y') ?? '—';
    }

    // Cek apakah user adalah Super Admin
    public function isSuperAdmin(): bool
    {
        return $this->role === 'Super Admin';
    }
}
