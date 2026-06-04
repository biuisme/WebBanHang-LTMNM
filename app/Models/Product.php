<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Khai báo các cột được phép thêm dữ liệu
    protected $fillable = [
        'category_id', 
        'name', 
        'price', 
        'image', 
        'description', 
        'quantity'
    ];

    /**
     * Định nghĩa quan hệ đảo ngược: 1 Sản phẩm thuộc về 1 Danh mục
     */
    public function category()
    {
        // belongsTo nghĩa là "thuộc về"
        return $this->belongsTo(Category::class);
    }
}
