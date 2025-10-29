<nav class="bg-white flex justify-end gap-5 px-15 py-8 drop-shadow-md relative">
    <i id="notifIcon" data-lucide="bell-ring" class="w-8 h-8 cursor-pointer"></i>
    <i id="userIcon" data-lucide="circle-user-round" class="w-8 h-8 cursor-pointer"></i>

    <!-- Modal Notifikasi -->
    <div id="notifModal" class="hidden absolute top-16 right-16 bg-white shadow-lg rounded-lg w-64 p-4 z-50">
        <h3 class="font-semibold mb-2">Notifikasi</h3>
        <p class="text-sm text-gray-500">Belum ada notifikasi.</p>
    </div>

    <!-- Modal User -->
    <div id="userModal" class="hidden absolute top-16 right-4 bg-white shadow-lg rounded-lg w-48 p-4 z-50">
        <h3 class="font-semibold mb-2">admin</h3>
        <ul class="text-sm text-gray-600 flex-col space-y-2">
            <li class="hover:text-blue-600 cursor-pointer"><span class="flex items-center gap-2"><i data-lucide="settings"></i>Setting</span></li>
            <li class="hover:text-blue-600 cursor-pointer"><span class="flex items-center gap-2"><i data-lucide="log-out"></i>Logout</span></li>
        </ul>
    </div>
</nav>
