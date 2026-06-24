<?php

use App\Libraries\enums\UserRole;

function auth_user()
{
    $auth = service('authentication');

    if (!$auth->check()) {
        return null;
    }

    return $auth->user();
}

function user_role()
{
    $user = auth_user();

    if (!$user) {
        return null;
    }

    // Superadmin
    if (!empty($user->is_superadmin)) {
        return \App\Libraries\enums\UserRole::SuperAdmin;
    }

    return null;
}

function getUserRole(int|string $role): string
{
    return UserRole::from(intval($role))->label();
}

function is_wali_kelas(): bool
{
    $user = auth_user();

    if (!$user) {
        return false;
    }

    return !empty($user->id_member);
}

function is_superadmin(): bool
{
    $user = auth_user();

    if (!$user) {
        return false;
    }

    return user_role()->isSuperAdmin();
}

function is_kepsek(): bool
{
    return user_role() === UserRole::Kepsek;
}

function can_edit_attendance(): bool
{
    return in_array(user_role(), [UserRole::SuperAdmin, UserRole::StafPetugas]);
}

function can_generate_qr(): bool
{
    return in_array(user_role(), [UserRole::SuperAdmin, UserRole::StafPetugas]);
}

function can_view_report(): bool
{
    return in_array(user_role(), [UserRole::SuperAdmin, UserRole::StafPetugas, UserRole::Kepsek]);
}
