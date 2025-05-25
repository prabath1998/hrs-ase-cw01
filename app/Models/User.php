<?php

declare(strict_types=1);

namespace App\Models;

use App\Notifications\AdminResetPasswordNotification;
use Illuminate\Auth\Notifications\ResetPassword as DefaultResetPassword;
use App\Traits\AuthorizationChecker;
use App\Traits\HasGravatar;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, HasGravatar, HasRoles, Notifiable, AuthorizationChecker;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_verified_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function actionLogs()
    {
        return $this->hasMany(ActionLog::class, 'action_by');
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        // Check if the request is for the admin panel
        if (request()->is('admin/*')) {
            $this->notify(new AdminResetPasswordNotification($token));
        } else {
            $this->notify(new DefaultResetPassword($token));
        }
    }

    public function customer()
    {
        return $this->hasOne(Customer::class);
    }

    public function travelCompany()
    {
        return $this->hasOne(TravelCompany::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'booked_by_user_id');
    }

    public function bills()
    {
        return $this->hasMany(Bill::class, 'generated_by_user_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'processed_by_user_id');
    }
}
