<?php

namespace App\Helpers;

use App\Models\User;

class UserHelper
{
    public $user;
    // protected User $user;
    /**
     * Create a new class instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function user(): User
    {
        return $this->user;
    }
    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullName(): string
    {
        return $this->user->first_name . ' ' . $this->user->last_name;
    }
    
    /**
     * Get the user's email address.
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->user->email;
    }
    /**
     * Get the user's role.
     *
     * @return string
     */
    public function getRole(): string
    {
        return $this->user->roles->first()->name ?? 'No Role';
    }

    /**
     * Check if the user is active.
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->user->status;
    }

    /**
     * Get the user's ID.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->user->id;
    }

    public function getMasaBerlaku(): string
    {
        $masaBerlaku = $this->user->masa_berlaku;
        if ($masaBerlaku) {
            return $masaBerlaku->format('d-m-Y');
        }
        return 'Tidak ada masa berlaku';
    }
        
    /**
     * Get the user's Kata Kunci.
     *
     * @return string
     */
    public function getKataKunci(): string
    {
        return $this->user->kata_kunci ?? '';
    }

    /**
     * Get the user's phone number.
     *
     * @return string
     */
    public function getKbli(): string
    {
        return $this->user->kbli ?? '';
    }

    public function isAdmin(): bool
    {
        return $this->user->group_id === 1; // Assuming group_id 1 is for admin
    }

    public function tambahMasaBerlaku(int $days): void
    {
        $this->user->masa_berlaku = now()->addDays($days);
        $this->user->save();
    }
}
