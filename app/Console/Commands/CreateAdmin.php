<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

#[Signature('admin:create')]
#[Description('Create a new admin user')]
class CreateAdmin extends Command
{
    public function handle(): int
    {
        $email = $this->ask('Email address');

        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error('Invalid email address.');

            return self::FAILURE;
        }

        if (User::where('email', $email)->exists()) {
            $this->error("A user with email {$email} already exists.");

            return self::FAILURE;
        }

        $generated = false;

        if ($this->confirm('Generate a password automatically?', true)) {
            $password = Str::password(16);
            $generated = true;
        } else {
            $password = $this->secret('Password');
            $confirm = $this->secret('Confirm password');

            if ($password !== $confirm) {
                $this->error('Passwords do not match.');

                return self::FAILURE;
            }

            if (strlen($password) < 8) {
                $this->error('Password must be at least 8 characters.');

                return self::FAILURE;
            }
        }

        User::create([
            'name' => 'Admin',
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $this->info('Admin user created successfully.');

        if ($generated) {
            $this->table(['Email', 'Password'], [[$email, $password]]);
            $this->warn('Save this password — it will not be shown again.');
        } else {
            $this->line("  Email: {$email}");
        }

        return self::SUCCESS;
    }
}
