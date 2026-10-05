<div class="card sidebar-card">

    <div class="card-body p-4">

        <div class="d-flex align-items-center mb-4">

            @if(Auth::user()->photo)

                <img
                    src="{{ asset('uploads/profile/'.Auth::user()->photo) }}"
                    width="65"
                    height="65"
                    class="rounded-circle me-3"
                    style="object-fit:cover;">

            @else

                <div class="profile-avatar me-3">

                    {{ strtoupper(substr(Auth::user()->name,0,1)) }}

                </div>

            @endif

            <div>

                <h6 class="fw-bold mb-1">

                    {{ Auth::user()->name }}

                </h6>

                <small class="text-muted">

                    Kelola Akun

                </small>

            </div>

        </div>

        <hr>

        <div class="menu-profile">

            <a
                href="/profile-pelanggan"
                class="menu-item {{ request()->is('profile-pelanggan') ? 'active' : '' }}">

                <i class="bi bi-person-fill"></i>

                Profil Saya

            </a>

           <a
    href="{{ route('customer.reports.index') }}"
    class="menu-item {{ request()->is('pelanggan/reports*') ? 'active' : '' }}">

    <i class="bi bi-file-earmark-bar-graph-fill"></i>

    Laporan

</a>

            <a
                href="/ubah-password"
                class="menu-item {{ request()->is('ubah-password') ? 'active' : '' }}">

                <i class="bi bi-lock-fill"></i>

                Ubah Password

            </a>

           <a
    href="/my-orders"
    class="menu-item {{ request()->is('my-orders') ? 'active' : '' }}">

    <i class="bi bi-clipboard-check-fill"></i>

    Pesanan Saya

</a>

<a
    href="{{ route('customer.balance') }}"
    class="menu-item {{ request()->is('saldo-pelanggan') ? 'active' : '' }}">

    <i class="bi bi-wallet2"></i>

    Saldo Saya

</a>

<a
    href="/pengaturan-akun"
    class="menu-item {{ request()->is('pengaturan-akun') ? 'active' : '' }}">

    <i class="bi bi-gear-fill"></i>

    Pengaturan Akun

</a>
        </div>

    </div>

</div>