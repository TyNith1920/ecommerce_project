<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Support\Facades\Schema;

class Product extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = [
        'title',
        'description',
        'price',
        'discount_price',
        'quantity',
        'category',
        'image',
        'slug',
        'gallery',
        'sizes',
        'seller_id',
    ];

    protected $casts = [
        'sizes'   => 'array',
        'gallery' => 'array',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => ['source' => 'title'],
        ];
    }

    /* ---------- Relations ---------- */
    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }
    public function specifications()
    {
        return $this->hasMany(Specification::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    /* ---------- Scopes ---------- */
    public function scopeSearch($q, ?string $term)
    {
        if (!$term) return $q;
        $like = "%{$term}%";
        return $q->where(function ($w) use ($like) {
            $w->where('title', 'like', $like)
                ->orWhere('description', 'like', $like)
                ->orWhere('slug', 'like', $like);
        });
        // FULLTEXT version (ប្រសិនបើបានបង្កើត index):
        // return $q->whereRaw("MATCH(title, description) AGAINST (? IN NATURAL LANGUAGE MODE)", [$term]);
    }

    public function scopeCategory($q, ?string $cat)
    {
        return $cat ? $q->where('category', $cat) : $q;
    }

    public function scopePriceRange($q, $min, $max)
    {
        $hasMin = is_numeric($min);
        $hasMax = is_numeric($max);
        if ($hasMin && $hasMax) return $q->whereBetween('price', [(float)$min, (float)$max]);
        if ($hasMin) return $q->where('price', '>=', (float)$min);
        if ($hasMax) return $q->where('price', '<=', (float)$max);
        return $q;
    }

    public function scopeHasDiscount($q, ?bool $flag)
    {
        if ($flag === null) return $q;
        return $flag
            ? $q->whereNotNull('discount_price')->whereColumn('discount_price', '<', 'price')
            : $q->where(function ($w) {
                $w->whereNull('discount_price')->orWhereColumn('discount_price', '>=', 'price');
            });
    }

    public function scopeSize($q, ?string $size)
    {
        // បង្កើតជាមួយ column sizes ទើប filter; បើ project មិនទាន់ migrate មិនទាន់ហៅ
        if (!$size || !Schema::hasColumn($this->getTable(), 'sizes')) return $q;
        return $q->whereJsonContains('sizes', $size);
    }

    public function scopeSortByParam($q, string $sort, ?string $term = null)
    {
        return $q
            ->when($sort === 'price_asc',  fn($qr) => $qr->orderByRaw('COALESCE(discount_price, price) ASC'))
            ->when($sort === 'price_desc', fn($qr) => $qr->orderByRaw('COALESCE(discount_price, price) DESC'))
            ->when($sort === 'newest',     fn($qr) => $qr->latest())
            ->when($sort === 'relevance',  function ($qr) use ($term) {
                if ($term) {
                    $qr->orderByRaw('CASE WHEN title LIKE ? THEN 0 ELSE 1 END', ["%{$term}%"])
                        ->orderByDesc('created_at');
                } else {
                    $qr->latest();
                }
            }, fn($qr) => $qr->latest());
    }

    /* ---------- Accessors ---------- */
    public function getFinalPriceAttribute(): float
    {
        $base = (float)($this->price ?? 0);
        $disc = $this->discount_price !== null ? (float)$this->discount_price : null;
        return ($disc !== null && $disc > 0 && $disc < $base) ? $disc : $base;
    }

    public function getPrimaryImageUrlAttribute(): string
    {
        $gallery = is_array($this->gallery) ? $this->gallery : (json_decode($this->gallery ?? '[]', true) ?? []);
        $first   = $gallery[0] ?? null;
        $rel     = $first ? 'products/' . ltrim($first, '/') : ($this->image ? 'products/' . ltrim($this->image, '/') : 'images/no-image.png');
        return asset($rel);
    }
}
