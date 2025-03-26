<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as FilamentDashboard;
use Illuminate\Support\Facades\Auth;

class Dashboard extends FilamentDashboard
{
    public function getHeading(): string
    {
        $user = Auth::user();
        return $user ? 'Bem-vindo, ' . $user->name : 'Dashboard';
    }
}
