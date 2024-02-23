<x-app-layout>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="container mx-auto">
        <div class="mb-4 flex justify-between items-center">
            <button class="bg-blue-500 text-white px-4 py-2 rounded mt-3">Maak een nieuw project</button>
        </div>

        <div class="grid grid-cols-3 gap-4">
            
            <!-- Hier voeg je de data grid items toe -->
            <div class="bg-white p-4 rounded shadow-md">
                <p>test </p>
            </div>
            <div class="bg-white p-4 rounded shadow-md">
                <p>test</p>
            </div>
            <div class="bg-white p-4 rounded shadow-md">
                <!-- Inhoud van grid item 3 -->
            </div>
            <div class="bg-white p-4 rounded shadow-md">
                <!-- Inhoud van grid item 3 -->
            </div>
            <!-- Voeg meer grid items toe zoals hierboven -->
        </div>
    </div>
    
</x-app-layout>
