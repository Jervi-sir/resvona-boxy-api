<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div>
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <a href="{{ route('users.add') }}">create Users</a>
                </button>
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <a href="{{ route('users.hardCreatePage') }}">manually creating Users</a>
                </button>
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <a href="https://boxydz.netlify.app/" target="_blank">goto site</a>
                </button>
                <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    <a href="{{ route('dashboard') }}">dashboard</a>
                </button>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('users.create') }}" method="POST">
                        @csrf
                        <input type="number" class="px-4 py-3" style="width: 10rem;" name="quantity" min="1" max="10">
                        <button class="bg-green-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="submit">create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

