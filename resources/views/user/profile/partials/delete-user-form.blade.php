<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            Hapus Akun
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Setelah akun Anda dihapus, semua data akan dihapus secara permanen.
        </p>
    </header>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="btn btn-outline-danger d-inline-flex align-items-center"
    >
        <i class="fas fa-trash me-2"></i>
        Hapus Akun
    </button>

    <!-- Modal -->
    <div
        x-data="{ show: false }"
        x-on:open-modal.window="$event.detail == 'confirm-user-deletion' ? show = true : null"
        x-on:close.stop="show = false"
        x-on:keydown.escape.window="show = false"
        x-show="show"
        class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50"
        style="display: none;"
        x-cloak
    >
        <div x-show="show" class="fixed inset-0 transform transition-all" x-on:click="show = false">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <div x-show="show" class="mb-6 bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:max-w-md sm:mx-auto" x-on:click.stop="">
            <form method="post" action="{{ route('user.profile.destroy') }}" class="p-6" onsubmit="return confirm('Apakah Anda benar-benar yakin ingin menghapus akun ini?');">
                @csrf
                @method('delete')

                <h2 class="text-lg font-medium text-gray-900">
                    Apakah Anda yakin ingin menghapus akun Anda?
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    Setelah akun Anda dihapus, semua sumber daya dan data akan dihapus secara permanen. Silakan masukkan password Anda untuk mengkonfirmasi bahwa Anda ingin menghapus akun secara permanen.
                </p>

                <div class="mt-6">
                    <label for="password" class="sr-only">Password</label>

                    <input
                        id="password"
                        name="password"
                        type="password"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        placeholder="Password"
                        required
                    />

                    @error('password', 'userDeletion')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="button" x-on:click="show = false" class="btn btn-outline-secondary d-inline-flex align-items-center me-3">
                        Batal
                    </button>

                    <button type="submit" class="btn btn-outline-danger d-inline-flex align-items-center">
                        <i class="fas fa-trash me-2"></i>
                        Hapus Akun
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>