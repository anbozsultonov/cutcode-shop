<?php

namespace App;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @class User
 * @property-read int $id
 * @property string $name
 * @property string $email
 * @property string $github_id
 * @method static Builder|User query()
 *
 * */
class User extends \Domain\Auth\Models\User
{

}
