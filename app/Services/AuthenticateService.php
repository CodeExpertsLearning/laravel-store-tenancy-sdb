<?php 
namespace App\Services; 

use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use App\Models\User;


class AuthenticateService
{
    public function __construct(private User $user){}

    public function login($credentials)
    {
        $user = $this->user->where('store_id', $credentials['store_id'])
                           ->where('tenant_id', $credentials['tenant_id'])
                           ->where('email', $credentials['email'])
                           ->first();

        if(!$user) throw new UnauthorizedHttpException("Invalid Credentials");

        if(!Hash::check($credentials['password'], $user->password)) throw new UnauthorizedHttpException("Invalid Credentials");

        auth()->login($user);

        return true;
    }
}