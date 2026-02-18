<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'email', 
        'subject', // Konu başlığı genellikle istenir
        'phone',   // Geri dönüş için telefon numarası
        'message', 
        'ip_address', // Güvenlik ve spam takibi için
        'is_read'     // Okundu/Okunmadı takibi
    ];

    /**
     * Veri Tipi Dönüşümleri
     */
    protected $casts = [
        'is_read' => 'boolean',
        'created_at' => 'datetime',
    ];

    /**
     * Scope: Sadece okunmamış mesajları getir
     * Kullanım: ContactMessage::unread()->get()
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Mesajı okundu olarak işaretle
     */
    public function markAsRead(): bool
    {
        return $this->update(['is_read' => true]);
    }
}