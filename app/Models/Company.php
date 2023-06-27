<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Company extends Model
{
    use HasFactory;
    protected $fillable =
    [
        'name',
        'code',
        'GSTIN',
        'phone',
        'email',
        'address',
        'logo',
        'signature',
        'business_type',
        'business_categories',
        'state_id',
        'description',
        'open_status',
        'active_status',
        'is_parent',
        'user_id',


    ];
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        if ($this->isDirty('name')) {
            $this->attributes['code'] = $this->generateUniqueSlug($value);
        }
    }

    public function generateSlug($name){
        return $this->generateUniqueSlug($name);
    }
    protected function generateUniqueSlug($name)
    {
        $slug = Str::random(8);
        $count = 0;
        while ($this->slugExists($slug)) {
            $count++;
            $slug = Str::random(8);
        }
        return $slug;
    }

    protected function slugExists($slug)
    {
        return static::where('code', $slug)->where('id', '!=', $this->id)->exists();
    }


    public static function setActive($company)
    {
        if ($company) {
            $company->open_status = 1;
            $company->save();
        } else {
            // Handle the case where the company doesn't exist
            // You can throw an exception, return an error response, or perform any other desired action
            return response()->json([
                'status' => false,
                'message' => 'Invalid Login Error',

            ]);
        }
    }

    // public function users()
    // {
    //     return $this->belongsTo(User::class);
    // }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_company');
    }

}
