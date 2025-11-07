@extends('layouts.admin')

@section('title', 'Dashboard')



@section('content')

    <div class="mt-7 px-15">
        <div class="flex gap-4 mt-4 justify-between items-center">
            <div>
                <h3 class="font-bold text-2xl text-secondary">Setting</h3>
            </div>

        </div>

        <!-- Wrapper utama -->
        <div class="w-full bg-white rounded-lg shadow-md mt-6 overflow-hidden">
            <!-- Tab Header -->
            <div class="flex bg-gray-200 border-b border-gray-300 text-sm font-medium text-gray-600 rounded-t-lg">
                <button class="px-6 py-3 border-b-2">
                    General
                </button>
                <button class="px-6 py-3">
                    Update
                </button>
                <button class="px-6 py-3">
                    Account
                </button>
            </div>

            <!-- Tab Content -->
            <div class="p-6 text-sm bg-white rounded-b-lg">
                <!-- General Tab -->
                <div class="space-y-4">
                    <!-- Theme -->
                    <div class="flex items-center gap-4">
                        <label class="w-32 text-secondary flex items-center font-semibold gap-2">
                            Tema
                            <i data-lucide="circle-alert" class="w-4 h-4 text-secondary"></i>
                        </label>
                        <div class="flex items-center">
                            <div class="flex overflow-hidden border-3 border-secondary">
                                <button
                                    class="w-10 py-1 text-primary bg-white hover:bg-primary hover:text-white transition place-content-center flex">
                                    <i data-lucide="sun"></i>
                                </button>
                                <button
                                    class="w-10 py-1 text-primary bg-white hover:bg-primary hover:text-white transition border-l-3 flex place-content-center">
                                    <i data-lucide="moon"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Language -->
                    <div class="flex items-center gap-4">
                        <label class="w-32 text-secondary flex items-center font-semibold gap-2">
                            Bahasa
                            <i data-lucide="circle-alert" class="w-4 h-4 text-secondary"></i>
                        </label>
                        <div class="flex items-center">
                            <div class="flex overflow-hidden border-3 border-secondary">
                                <button
                                    class="w-10 py-1 text-primary bg-white hover:bg-primary hover:text-white transition font-semibold">
                                    IND
                                </button>
                                <button
                                    class="w-10 py-1 text-primary bg-white hover:bg-primary hover:text-white transition border-l-3 font-semibold">
                                    EN
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Notification -->
                    <div class="flex items-center gap-4">
                        <label class="w-32 text-secondary flex items-center font-semibold gap-2">
                            Notifikasi
                            <i data-lucide="circle-alert" class="w-4 h-4 text-secondary"></i>
                        </label>
                        <div class="flex items-center">
                            <div class="flex overflow-hidden border-3 border-secondary">
                                <button
                                    class="w-10 py-1 text-primary bg-white hover:bg-primary hover:text-white transition font-semibold">
                                    ON
                                </button>
                                <button
                                    class="w-10 py-1 text-primary bg-white hover:bg-primary hover:text-white transition border-l-3 font-semibold">
                                    OFF
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>






    </div>
@endsection
