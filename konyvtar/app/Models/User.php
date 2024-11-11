<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin()  {  //!!!!!!!!!!!!!
        return $this->role === 0;
    }
    public function isLibrarian()  {  //!!!!!!!!!!!!!
        return $this->role === 1;
    }
    public function isWarehouseman()  {  //!!!!!!!!!!!!!
        return $this->role === 2;
    }
    public function isUser()  {  //!!!!!!!!!!!!!
        return $this->role === 3;
    }

    public function lendings()
        {  
            //kapcsolat iránya, paraméterek sorrendje: model, honnan, hová
            return $this->hasMany(Lending::class, 'user_id','id');  
        }

}
