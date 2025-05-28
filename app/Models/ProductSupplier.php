<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSupplier extends Model
{
    use CrudTrait;
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'product_suppliers';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];



    protected $fillable = [
        'product_id',
        'supplier_id',  
        'cost_price',
        'supplier_product_code',
    ];


    
    // protected $fillable = [];
    // protected $hidden = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class,'supplier_id');
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
