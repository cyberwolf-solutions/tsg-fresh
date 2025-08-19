<?php



namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WebCustomer extends Authenticatable
{
    use HasFactory, Notifiable;

     protected $connection = 'central';
    protected $table = 'web_customers';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'loyalty',
        'remember_token'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function billingAddress()
    {
        return $this->hasOne(BillingAddress::class, 'customer_id');
    }
}
