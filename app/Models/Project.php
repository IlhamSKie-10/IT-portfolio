<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;

/**
 * Project Model
 *
 * Represents a portfolio project managed via Filament admin.
 *
 * @property int    $id
 * @property string $title
 * @property string $slug
 * @property string $description
 * @property string|null $long_description
 * @property array  $tech_stack
 * @property string|null $screenshot
 * @property string $status   (active|completed|archived)
 * @property string $type     (erp|webapp|ai|other)
 * @property int    $sort_order
 * @property bool   $is_featured
 */
class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'long_description',
        'tech_stack',
        'screenshot',
        'status',
        'type',
        'sort_order',
        'is_featured',
    ];

    protected $casts = [
        'tech_stack'  => 'array',
        'is_featured' => 'boolean',
        'sort_order'  => 'integer',
    ];

    // ── Scopes ────────────────────────────────────

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)
                     ->orderBy('sort_order');
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', ['active', 'completed']);
    }

    // ── Accessors ─────────────────────────────────

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'active'    => 'In Development',
            'completed' => 'Completed',
            'archived'  => 'Archived',
            default     => ucfirst($this->status),
        };
    }

    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'erp'    => 'Enterprise ERP',
            'webapp' => 'Business Web App',
            'ai'     => 'AI / ML',
            default  => ucfirst($this->type),
        };
    }

    public function getScreenshotUrlAttribute(): ?string
    {
        return $this->screenshot
            ? asset('storage/' . $this->screenshot)
            : null;
    }
}
